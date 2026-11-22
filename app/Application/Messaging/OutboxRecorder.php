<?php

declare(strict_types=1);

namespace App\Application\Messaging;

use Illuminate\Support\Facades\DB;

final class OutboxRecorder
{
    /** Call inside the same DB transaction as the domain change. */
    public function record(IntegrationEvent $event): void
    {
        DB::table('integration_outbox')->insert([
            'event_id' => $event->eventId,
            'routing_key' => $event->routingKey(),
            'body' => $event->toJson(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
