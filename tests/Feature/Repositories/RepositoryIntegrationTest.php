<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Address;
use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderInstallment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class RepositoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private function startTenant(): Tenant
    {
        $tenant = Tenant::factory()->create();
        $this->actingAs(User::factory()->for($tenant, 'tenant')->create());
        return $tenant;
    }

    private function relatedData(Tenant $tenant): array
    {
        $person = Person::factory()->forTenant($tenant->id)->create();
        $order = WorkOrder::factory()->forTenant($tenant->id)
            ->for($person, 'person')->create();
        return [$person, $order];
    }

    public static function cases(): array
    {
        return [
            'Tenant' => [\App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface::class, \App\Models\Tenant::class, \App\Domain\V1\Tenant\ValueObjects\TenantId::class, 'Tenant'],
            'Person' => [\App\Domain\V1\Person\Repositories\PersonRepositoryInterface::class, \App\Models\Person::class, \App\Domain\V1\Person\ValueObjects\PersonId::class, 'Person'],
            'Address' => [\App\Domain\V1\Address\Repositories\AddressRepositoryInterface::class, \App\Models\Address::class, \App\Domain\V1\Address\ValueObjects\AddressId::class, 'Address'],
            'WorkOrder' => [\App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface::class, \App\Models\WorkOrder::class, \App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId::class, 'WorkOrder'],
            'WorkOrderItem' => [\App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface::class, \App\Models\WorkOrderItem::class, \App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId::class, 'WorkOrderItem'],
            'WorkOrderInstallment' => [\App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface::class, \App\Models\WorkOrderInstallment::class, \App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId::class, 'WorkOrderInstallment'],
        ];
    }

    private function factoryRecord(string $name, Tenant $tenant): object
    {
        if ($name === 'Tenant') {
            return Tenant::factory()->create();
        }

        [$person, $order] = $this->relatedData($tenant);

        return match ($name) {
            'Person' => $person,
            'Address' => Address::factory()->forTenant($tenant->id)->for($person, 'person')->create(),
            'WorkOrder' => $order,
            'WorkOrderItem' => WorkOrderItem::factory()->forWorkOrder($order)->create(),
            'WorkOrderInstallment' => WorkOrderInstallment::factory()->forTenant($tenant->id)
                ->create(['work_order_id' => $order->id]),
        };
    }

    #[DataProvider('cases')]
    public function testRepositoryCanFindListAndSoftDelete(
        string $interface,
        string $modelClass,
        string $idClass,
        string $name,
    ): void {
        $tenant = $this->startTenant();
        $record = $this->factoryRecord($name, $tenant);
        $repository = app($interface);
        $id = new $idClass($record->id);

        $entity = $repository->findById($id);
        $this->assertNotNull($entity);
        $this->assertSame((string) $record->id, (string) $entity->getId());
        $this->assertNotEmpty($repository->getAll([], 100));

        $repository->destroy($id);
        $this->assertNull($repository->findById($id));
        $this->assertNotNull($modelClass::withTrashed()->find($record->id));
    }

    #[DataProvider('cases')]
    public function testRepositoryRejectsUnknownFilters(
        string $interface,
        string $modelClass,
        string $idClass,
        string $name,
    ): void {
        $tenant = $this->startTenant();
        $this->factoryRecord($name, $tenant);
        $this->expectException(\InvalidArgumentException::class);
        app($interface)->getAll(['not_an_allowed_column' => 1], 10);
    }
}
