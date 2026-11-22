<?php

declare(strict_types=1);

namespace App\Application\Messaging;

use InvalidArgumentException;
use Illuminate\Support\Facades\DB;

/** Syncs a separate read-model. Does not write to the Person aggregate. */
final class InboundCustomerProjector
{
    public function apply(IntegrationEvent $event): void
    {
        if (!in_array($event->eventType, ['customer.created', 'customer.updated'], true) || $event->eventVersion !== 1) {
            throw new InvalidArgumentException('Unsupported customer event.');
        }
        $externalId = $event->payload['customer_id'] ?? null;
        $firstName = $event->payload['first_name'] ?? null;
        if (!is_scalar($externalId) || trim((string) $externalId) === '' || !is_string($firstName) || trim($firstName) === '') {
            throw new InvalidArgumentException('Invalid customer payload.');
        }
        $localTenantId = DB::table('integration_tenant_mappings')
            ->where('producer', $event->producer)
            ->where('external_tenant_id', $event->tenantId)
            ->value('local_tenant_id');
        if ($localTenantId === null) {
            throw new InvalidArgumentException('Unmapped tenant for producer.');
        }
        DB::table('integration_remote_customers')->upsert([[
            'tenant_id' => $localTenantId,
            'producer' => $event->producer,
            'external_customer_id' => (string) $externalId,
            'first_name' => $firstName,
            'last_name' => isset($event->payload['last_name']) ? (string) $event->payload['last_name'] : null,
            'active' => (bool) ($event->payload['active'] ?? true),
            'updated_at' => now(),
            'created_at' => now(),
        ]], ['tenant_id', 'producer', 'external_customer_id'], ['first_name', 'last_name', 'active', 'updated_at']);
    }
}
