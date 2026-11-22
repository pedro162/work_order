<?php

declare(strict_types=1);

namespace Tests\Unit\Application;

use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class HandlerContractTest extends TestCase
{
    public static function cases(): array
    {
        return [
            'Tenant' => ['Tenant', \App\Domain\V1\Tenant\Entities\Tenant::class, \App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface::class, 'name', 'Example Company'],
            'Person' => ['Person', \App\Domain\V1\Person\Entities\Person::class, \App\Domain\V1\Person\Repositories\PersonRepositoryInterface::class, 'first_name', 'Jane'],
            'Address' => ['Address', \App\Domain\V1\Address\Entities\Address::class, \App\Domain\V1\Address\Repositories\AddressRepositoryInterface::class, 'person_id', 1],
            'WorkOrder' => ['WorkOrder', \App\Domain\V1\WorkOrder\Entities\WorkOrder::class, \App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface::class, 'external_code', 'OS-ABC'],
            'WorkOrderItem' => ['WorkOrderItem', \App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem::class, \App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface::class, 'work_order_id', 1],
            'WorkOrderInstallment' => ['WorkOrderInstallment', \App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment::class, \App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface::class, 'work_order_id', 1],
        ];
    }

    #[DataProvider('cases')]
    public function testGetByIdHandlerDelegatesToRepository(
        string $name,
        string $entityClass,
        string $interface,
        string $field,
        mixed $value,
    ): void {
        $entity = $entityClass::buildEntity(['id' => 3, $field => $value]);
        $repository = Mockery::mock($interface);
        $repository->shouldReceive('findById')->once()->withArgs(
            fn ($id) => (string) $id === '3'
        )->andReturn($entity);
        $handlerClass = sprintf(
            'App\\Application\\Handlers\\V1\\%s\\Get%sByIdHandler',
            $name,
            $name
        );
        $this->assertSame($entity, (new $handlerClass($repository))->handler(3));
    }

    #[DataProvider('cases')]
    public function testListHandlerReturnsCollectionWithoutDatabase(
        string $name,
        string $entityClass,
        string $interface,
    ): void {
        $repository = Mockery::mock($interface);
        $repository->shouldReceive('getAll')->once()->with(['active' => true], 25)->andReturn([]);
        $handlerClass = sprintf(
            'App\\Application\\Handlers\\V1\\%s\\GetAll%sHandler',
            $name,
            $name
        );
        $result = (new $handlerClass($repository))->handler(['active' => true], 25);
        $this->assertCount(0, $result);
    }

    #[DataProvider('cases')]
    public function testDeleteHandlerDelegatesValueObjectId(
        string $name,
        string $entityClass,
        string $interface,
    ): void {
        $commandClass = sprintf(
            'App\\Application\\Commands\\V1\\%s\\Delete%sCommand',
            $name,
            $name
        );
        $handlerClass = sprintf(
            'App\\Application\\Handlers\\V1\\%s\\Destroy%sHandler',
            $name,
            $name
        );
        $repository = Mockery::mock($interface);
        $repository->shouldReceive('destroy')->once()->withArgs(
            fn ($id) => (string) $id === '9'
        );
        (new $handlerClass($repository))->handler($commandClass::build(['id' => 9]));
    }
}
