<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Application\Messaging\Contracts\EventPublisherInterface;
use App\Application\Messaging\IntegrationEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

final class PublishIntegrationOutbox extends Command
{
    protected $signature = 'integration:publish-outbox {--limit=100}';
    protected $description = 'Publish pending integration events with RabbitMQ confirmations';

    public function handle(EventPublisherInterface $publisher): int
    {
        $limit = max(1, min(1000, (int) $this->option('limit')));
        $rows = DB::table('integration_outbox')
            ->whereNull('published_at')
            ->where('next_attempt_at', '<=', now())
            ->orWhere(function ($query): void {
                $query->whereNull('published_at')->whereNull('next_attempt_at');
            })
            ->orderBy('id')->limit($limit)->get();

        foreach ($rows as $row) {
            // Claim under row lock; prevents duplicate concurrent sends in the usual case.
            $claimed = DB::transaction(function () use ($row) {
                $current = DB::table('integration_outbox')->where('id', $row->id)->lockForUpdate()->first();
                if (!$current || $current->published_at !== null || ($current->locked_until !== null && $current->locked_until > now()->toDateTimeString())) {
                    return false;
                }
                DB::table('integration_outbox')->where('id', $row->id)->update(['locked_until' => now()->addSeconds(60)]);
                return true;
            });
            if (!$claimed) {
                continue;
            }
            try {
                $publisher->publish(IntegrationEvent::fromJson($row->body));
                DB::table('integration_outbox')->where('id', $row->id)->update([
                    'published_at' => now(), 'locked_until' => null, 'updated_at' => now(),
                ]);
            } catch (Throwable $exception) {
                DB::table('integration_outbox')->where('id', $row->id)->update([
                    'attempts' => DB::raw('attempts + 1'),
                    'locked_until' => null,
                    'next_attempt_at' => now()->addSeconds(min(3600, 2 ** min(10, (int) $row->attempts + 1))),
                    'last_error' => mb_substr($exception->getMessage(), 0, 1000),
                    'updated_at' => now(),
                ]);
                report($exception);
            }
        }
        return self::SUCCESS;
    }
}
