<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\WorkOrderItem;

use App\Application\Commands\V1\BaseUpdateCommand;

final class UpdateWorkOrderItemCommand extends BaseUpdateCommand
{
    protected static function fields(): array
    {
        return [
            'quantity' => 'decimal',
            'external_code' => 'string',
            'service_name' => 'string',
            'gross_item_amount' => 'decimal',
            'total_amount' => 'decimal',
            'item_amount' => 'decimal',
            'active' => 'bool',
            'work_order_id' => 'int',
            'final_amount' => 'decimal',
            'discount_amount' => 'decimal',
            'surcharge_percentage' => 'decimal',
            'surcharge_amount' => 'decimal',
            'discount_percentage' => 'decimal',
        ];
    }

    public function quantity(string $value): static
    {
        return $this->assign('quantity', $value);
    }

    public function externalCode(string $value): static
    {
        return $this->assign('external_code', $value);
    }

    public function serviceName(string $value): static
    {
        return $this->assign('service_name', $value);
    }

    public function grossItemAmount(string $value): static
    {
        return $this->assign('gross_item_amount', $value);
    }

    public function totalAmount(string $value): static
    {
        return $this->assign('total_amount', $value);
    }

    public function itemAmount(string $value): static
    {
        return $this->assign('item_amount', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
    }

    public function workOrderId(int $value): static
    {
        return $this->assign('work_order_id', $value);
    }

    public function finalAmount(string $value): static
    {
        return $this->assign('final_amount', $value);
    }

    public function discountAmount(string $value): static
    {
        return $this->assign('discount_amount', $value);
    }

    public function surchargePercentage(string $value): static
    {
        return $this->assign('surcharge_percentage', $value);
    }

    public function surchargeAmount(string $value): static
    {
        return $this->assign('surcharge_amount', $value);
    }

    public function discountPercentage(string $value): static
    {
        return $this->assign('discount_percentage', $value);
    }
}
