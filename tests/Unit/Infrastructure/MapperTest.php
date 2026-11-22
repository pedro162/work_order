<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use App\Infrastructure\Mappers\V1\TenantMapper;
use App\Infrastructure\Mappers\V1\PersonMapper;
use App\Infrastructure\Mappers\V1\AddressMapper;
use App\Infrastructure\Mappers\V1\WorkOrderMapper;
use App\Infrastructure\Mappers\V1\WorkOrderItemMapper;
use App\Infrastructure\Mappers\V1\WorkOrderInstallmentMapper;

final class MapperTest extends TestCase
{
    public static function cases(): array
    {
        return [
            'Tenant' => [
                TenantMapper::class,
                \App\Models\Tenant::class,
                'name',
                'Example Company'
            ],
            'Person' => [
                PersonMapper::class,
                \App\Models\Person::class,
                'first_name',
                'Jane'
            ],
            'Address' => [
                AddressMapper::class,
                \App\Models\Address::class,
                'person_id',
                1
            ],
            'WorkOrder' => [
                WorkOrderMapper::class,
                \App\Models\WorkOrder::class,
                'external_code',
                'OS-ABC'
            ],
            'WorkOrderItem' => [
                WorkOrderItemMapper::class,
                \App\Models\WorkOrderItem::class,
                'work_order_id',
                1
            ],
            'WorkOrderInstallment' => [
                WorkOrderInstallmentMapper::class,
                \App\Models\WorkOrderInstallment::class,
                'work_order_id',
                1
            ],
        ];
    }

    #[DataProvider('cases')]
    public function testMapperConvertsPersistenceRecordToDomainAndBack(
        string $mapperClass,
        string $modelClass,
        string $attribute,
        mixed $value,
    ): void {
        $model = new $modelClass();
        $model->setRawAttributes(['id' => 7, $attribute => $value], true);
        $mapper = new $mapperClass();
        $entity = $mapper->toDomain($model);
        $this->assertSame('7', (string) $entity->getId());
        $attributes = $mapper->toPersistence($entity);
        $this->assertArrayHasKey($attribute, $attributes);
        $this->assertEquals($value, $attributes[$attribute]);
        $this->assertArrayNotHasKey('tenant_id', $attributes);
    }

    public function testPersonMapperPreservesFalse(): void
    {
        $entity = \App\Domain\V1\Person\Entities\Person::buildEntity([
            'first_name' => 'Jane',
            'active' => false,
        ]);
        $data = (new PersonMapper())->toPersistence($entity);
        $this->assertSame(false, $data['active']);
    }
}
