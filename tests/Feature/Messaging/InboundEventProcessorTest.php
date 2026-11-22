<?php

declare(strict_types=1);

namespace Tests\Feature\Messaging;

use App\Application\Messaging\InboundEventProcessor;
use App\Application\Messaging\IntegrationEvent;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Tests\TestCase;

final class InboundEventProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function testConsumesSameEventOnlyOnceInCorrectTenant(): void
    {
        config()->set('integration_messaging.allowed_producers', ['customer_api']);
        $tenant = Tenant::factory()->create();
        DB::table('integration_tenant_mappings')->insert([
            'producer' => 'customer_api', 'external_tenant_id' => 'external-15', 'local_tenant_id' => $tenant->id,
        ]);
        $event = new IntegrationEvent(
            'c0b7b5f0-8718-4f77-8c45-ef5f791b224d',
            'customer.created',
            1,
            '2026-11-22T16:00:00Z',
            'customer_api',
            'external-15',
            ['customer_id' => 44, 'first_name' => 'Jane', 'last_name' => 'Doe'],
        );
        $processor = app(InboundEventProcessor::class);
        $this->assertTrue($processor->process($event));
        $this->assertFalse($processor->process($event));
        $this->assertDatabaseCount('integration_inbox', 1);
        $this->assertDatabaseHas('integration_remote_customers', [
            'tenant_id' => $tenant->id, 'producer' => 'customer_api', 'external_customer_id' => '44', 'first_name' => 'Jane',
        ]);
    }

    public function testRejectsUnmappedTenantAndRollsBackInbox(): void
    {
        config()->set('integration_messaging.allowed_producers', ['customer_api']);
        $event = new IntegrationEvent(
            'd27d22b3-6a76-42b8-b1c9-7b6e19578a9f',
            'customer.updated',
            1,
            '2026-11-22T16:00:00Z',
            'customer_api',
            'unknown',
            ['customer_id' => 44, 'first_name' => 'Jane'],
        );
        $this->expectException(InvalidArgumentException::class);
        try {
            app(InboundEventProcessor::class)->process($event);
        } finally {
            $this->assertDatabaseCount('integration_inbox', 0);
        }
    }
}
