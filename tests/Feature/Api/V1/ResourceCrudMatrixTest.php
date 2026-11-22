<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class ResourceCrudMatrixTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Gate::define('manage-tenants', fn (User $user): bool => true);
        $tenant = Tenant::factory()->create();
        $this->actingAs(User::factory()->for($tenant, 'tenant')->create());
    }

    public static function cases(): array
    {
        return [
            'Tenant' => ['tenants', 'name', 'Company Two', 'Company Updated'],
            'Address' => ['addresses', 'street', 'First Street', 'Second Street'],
            'WorkOrder' => ['work_orders', 'status', 'PENDING', 'COMPLETED'],
            'WorkOrderItem' => ['work_order_items', 'service_name', 'Maintenance', 'Installation'],
            'WorkOrderInstallment' => ['work_order_installments', 'payment_method', 'PIX', 'CASH'],
        ];
    }

    private function routeParameter(string $resource): string
    {
        return match ($resource) {
            'tenants' => 'tenant',
            'addresses' => 'address',
            'work_orders' => 'work_order',
            'work_order_items' => 'work_order_item',
            'work_order_installments' => 'work_order_installment',
        };
    }

    private function payload(string $resource, string $field, string $value): array
    {
        if ($resource === 'tenants') {
            return [
                'name' => $value,
                'slug' => 'company-' . bin2hex(random_bytes(6)),
            ];
        }

        $person = Person::factory()->forTenant(auth()->user()->tenant_id)->create();
        $order = WorkOrder::factory()->forTenant(auth()->user()->tenant_id)
            ->for($person, 'person')->create();

        $base = match ($resource) {
            'addresses' => [
                'person_id' => $person->id,
                'zip_code' => '65000000',
                'street' => 'First Street',
                'city' => 'Sao Luis',
                'state' => 'MA',
            ],
            'work_orders' => ['person_id' => $person->id],
            'work_order_items' => ['work_order_id' => $order->id, 'service_name' => 'Maintenance'],
            'work_order_installments' => ['work_order_id' => $order->id, 'charge_amount' => '10.00'],
        };

        return [...$base, $field => $value];
    }

    #[DataProvider('cases')]
    public function testFullCrudLifecycle(
        string $resource,
        string $field,
        string $initial,
        string $updated,
    ): void {
        $payload = $this->payload($resource, $field, $initial);
        $created = $this->postJson(route("api.v1.{$resource}.store"), $payload)
            ->assertCreated()
            ->assertJsonPath("data.{$field}", $initial);
        $id = (int) $created->json('data.id');
        $this->assertGreaterThan(0, $id);

        $this->getJson(
            route("api.v1.{$resource}.show", [$this->routeParameter($resource) => $id])
        )->assertOk()->assertJsonPath("data.{$field}", $initial);
        $this->getJson(route("api.v1.{$resource}.index", ['limit' => 10]))
            ->assertOk()->assertJsonStructure(['data']);

        $this->patchJson(
            route("api.v1.{$resource}.update", [$this->routeParameter($resource) => $id]),
            [$field => $updated]
        )->assertOk()->assertJsonPath("data.{$field}", $updated);

        $this->deleteJson(
            route("api.v1.{$resource}.destroy", [$this->routeParameter($resource) => $id])
        )->assertNoContent();
        $this->getJson(
            route("api.v1.{$resource}.show", [$this->routeParameter($resource) => $id])
        )->assertNotFound();
    }
}
