<?php

declare(strict_types=1);

namespace Tests\Unit\Application;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class WriteCommandsTest extends TestCase
{
    public static function createCases(): array
    {
        return [
            'Tenant' => [\App\Application\Commands\V1\Tenant\CreateTenantCommand::class, ['name' => 'Company', 'slug' => 'example-company']],
            'Person' => [\App\Application\Commands\V1\Person\CreatePersonCommand::class, ['first_name' => 'Jane']],
            'Address' => [\App\Application\Commands\V1\Address\CreateAddressCommand::class, ['person_id' => 1, 'zip_code' => '65000000', 'street' => 'Main', 'city' => 'City', 'state' => 'MA']],
            'WorkOrder' => [\App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand::class, ['person_id' => 1]],
            'WorkOrderItem' => [\App\Application\Commands\V1\WorkOrderItem\CreateWorkOrderItemCommand::class, ['work_order_id' => 1, 'service_name' => 'Service', 'quantity' => '1']],
            'WorkOrderInstallment' => [\App\Application\Commands\V1\WorkOrderInstallment\CreateWorkOrderInstallmentCommand::class, ['work_order_id' => 1, 'charge_amount' => '10.00']],
        ];
    }

    #[DataProvider('createCases')]
    public function testCreateCommandsPreserveAllowedAttributes(string $class, array $input): void
    {
        $command = $class::build($input);
        foreach ($input as $key => $value) {
            $this->assertArrayHasKey($key, $command->getDataProperties());
            $this->assertEquals($value, $command->getDataProperties()[$key]);
        }
    }

    #[DataProvider('createCases')]
    public function testCreateCommandsRejectUnknownFields(string $class, array $input): void
    {
        $this->expectException(InvalidArgumentException::class);
        $class::build([...$input, 'tenant_id' => 999999]);
    }

    #[DataProvider('createCases')]
    public function testCreateCommandsRejectExplicitNull(string $class, array $input): void
    {
        $field = array_key_first($input);
        $this->expectException(InvalidArgumentException::class);
        $class::build([...$input, $field => null]);
    }

    #[DataProvider('createCases')]
    public function testUpdateCommandsPreserveOnlySuppliedFields(string $createClass, array $input): void
    {
        $class = str_replace('Create', 'Update', $createClass);
        $field = array_key_first($input);
        $command = $class::build(['id' => 10, $field => $input[$field]]);
        $this->assertSame(10, $command->getId());
        $this->assertArrayHasKey($field, $command->getDataProperties());
        $this->assertCount(2, $command->getDataProperties());
    }

    #[DataProvider('createCases')]
    public function testDeleteCommandsOnlyAcceptPositiveIdentifiers(string $createClass): void
    {
        $class = str_replace('Create', 'Delete', $createClass);
        $this->assertSame(5, $class::build(['id' => '5'])->getId());
        try {
            $class::build(['id' => 0]);
            $this->fail('A zero identifier must fail.');
        } catch (InvalidArgumentException) {
            $this->assertTrue(true);
        }
    }

    public static function preservedScalarCases(): array
    {
        return [
            'false is retained by update command' => [
                \App\Application\Commands\V1\Person\UpdatePersonCommand::class,
                ['id' => 1, 'active' => false], 'active', false,
            ],
            'zero is retained as decimal text' => [
                \App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand::class,
                ['person_id' => 1, 'total_amount' => '0.00'], 'total_amount', '0.00',
            ],
            'false is retained by create command' => [
                \App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand::class,
                ['person_id' => 1, 'is_quote' => false], 'is_quote', false,
            ],
        ];
    }

    #[DataProvider('preservedScalarCases')]
    public function testPreservesFalseAndZeroValues(
        string $commandClass,
        array $payload,
        string $field,
        mixed $expected
    ): void {
        $command = $commandClass::build($payload);

        $this->assertSame($expected, $command->getDataProperties()[$field]);
    }

    public function testDecimalFloatsAreRejectedToAvoidPrecisionLoss(): void
    {
        $this->expectException(InvalidArgumentException::class);
        \App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand::build([
            'person_id' => 1, 'total_amount' => 12.35,
        ]);
    }

    public function testUpdateRejectsMissingId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        \App\Application\Commands\V1\Person\UpdatePersonCommand::build(['first_name' => 'Jane'])
            ->getDataProperties();
    }
}
