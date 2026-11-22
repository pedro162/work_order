<?php

declare(strict_types=1);

namespace App\Application\Messaging;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final readonly class InboundEventProcessor
{
    public function __construct(private InboundCustomerProjector $projector)
    {
    }

    /** Returns true for a new event, false for an already processed event. */
    public function process(IntegrationEvent $event): bool
    {
        if (!in_array($event->producer, config('integration_messaging.allowed_producers', []), true)) {
            throw new InvalidArgumentException('Untrusted event producer.');
        }
        return DB::transaction(function () use ($event): bool {
            $inserted = DB::table('integration_inbox')->insertOrIgnore([
                'event_id' => $event->eventId,
                'producer' => $event->producer,
                'tenant_id' => $event->tenantId,
                'event_type' => $event->eventType,
                'created_at' => now(),
            ]);
            if ($inserted === 0) {
                return false;
            }
            $this->projector->apply($event);
            return true;
        });
    }
}
