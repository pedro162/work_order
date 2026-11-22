<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class EntityHydrationTest extends TestCase
{
    public static function cases(): array
    {
        return [
            'Tenant' => [\App\Domain\V1\Tenant\Entities\Tenant::class, 'name', 'Example Company', 'getName'],
            'Person' => [\App\Domain\V1\Person\Entities\Person::class, 'first_name', 'Jane', 'getFirstName'],
            'Address' => [\App\Domain\V1\Address\Entities\Address::class, 'person_id', 1, 'getPersonId'],
            'WorkOrder' => [\App\Domain\V1\WorkOrder\Entities\WorkOrder::class, 'external_code', 'OS-ABC', 'getExternalCode'],
            'WorkOrderItem' => [\App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem::class, 'work_order_id', 1, 'getWorkOrderId'],
            'WorkOrderInstallment' => [\App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment::class, 'work_order_id', 1, 'getWorkOrderId'],
        ];
    }

    #[DataProvider('cases')]
    public function testBuildEntityHydratesValueObjects(
        string $entityClass,
        string $attribute,
        mixed $value,
        string $getter,
    ): void {
        $entity = $entityClass::buildEntity([$attribute => $value]);
        $this->assertNotNull($entity->{$getter}());
        $this->assertSame((string) $value, (string) $entity->{$getter}());
    }

    #[DataProvider('cases')]
    public function testActiveFalseIsPreserved(string $entityClass): void
    {
        $entity = $entityClass::buildEntity(['active' => false]);
        $this->assertFalse($entity->getActive());
    }
}
