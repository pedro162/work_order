<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Domain\V1\Tenant\ValueObjects\TenantId;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemAmount;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ValueObjectTest extends TestCase
{
    public static function validIdProvider(): array
    {
        return [
            'tenant' => [TenantId::class, 42],
            'person' => [PersonId::class, 42],
            'address' => [AddressId::class, 42],
            'workOrder' => [WorkOrderId::class, '42'],
            'workOrderItem' => [WorkOrderItemId::class, 42],
            'workOrderInstallment' => [
                WorkOrderInstallmentId::class,
                42,
            ],
        ];
    }

    #[DataProvider('validIdProvider')]
    public function testAcceptsValidId(
        string $valueObjectClass,
        int|string $validValue
    ): void {
        $valueObject = new $valueObjectClass($validValue);

        $this->assertSame(
            '42',
            (string) $valueObject
        );
    }

    public static function invalidIdProvider(): array
    {
        $valueObjects = [
            'tenant' => TenantId::class,
            'person' => PersonId::class,
            'address' => AddressId::class,
            'workOrder' => WorkOrderId::class,
            'workOrderItem' => WorkOrderItemId::class,
            'workOrderInstallment' => WorkOrderInstallmentId::class,
        ];

        $datasets = [];

        foreach ($valueObjects as $name => $class) {
            $invalidValues = $name === 'workOrder'
                ? ['0', '-1', 'abc']
                : [0, '-1', 'abc'];

            foreach ($invalidValues as $index => $value) {
                $datasets["{$name}_{$index}"] = [
                    $class,
                    $value,
                ];
            }
        }

        return $datasets;
    }

    #[DataProvider('invalidIdProvider')]
    public function testRejectsInvalidId(
        string $valueObjectClass,
        int|string $invalidValue
    ): void {
        $this->expectException(
            InvalidArgumentException::class
        );

        new $valueObjectClass($invalidValue);
    }

    public static function validDecimalProvider(): array
    {
        return [
            'integer decimal' => ['10'],
            'two decimal places' => ['19.99'],
            'zero' => ['0'],
            'zero with decimals' => ['0.00'],
        ];
    }

    #[DataProvider('validDecimalProvider')]
    public function testPreservesDecimalValue(
        string $value
    ): void {
        $amount = new WorkOrderItemAmount($value);

        $this->assertSame(
            $value,
            (string) $amount
        );
    }

    public static function invalidDecimalProvider(): array
    {
        return [
            'comma separator' => ['19,99'],
            'alphabetic characters' => ['invalid'],
            'mixed characters' => ['19.99abc'],
        ];
    }

    #[DataProvider('invalidDecimalProvider')]
    public function testRejectsInvalidDecimalValue(
        string $invalidValue
    ): void {
        $this->expectException(
            InvalidArgumentException::class
        );

        new WorkOrderItemAmount($invalidValue);
    }
}
