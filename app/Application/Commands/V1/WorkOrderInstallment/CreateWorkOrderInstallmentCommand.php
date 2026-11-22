<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\WorkOrderInstallment;

use App\Application\Commands\V1\BaseWriteCommand;

final class CreateWorkOrderInstallmentCommand extends BaseWriteCommand
{
    protected static function fields(): array
    {
        return [
            'work_order_id' => 'int',
            'external_code' => 'string',
            'payment_method' => 'string',
            'document_number' => 'string',
            'charge_amount' => 'decimal',
            'surcharge_amount' => 'decimal',
            'final_amount' => 'decimal',
            'active' => 'bool',
        ];
    }

    protected static function requiredFields(): array
    {
        return ['work_order_id'];
    }

    public function workOrderId(int $value): static
    {
        return $this->assign('work_order_id', $value);
    }

    public function externalCode(string $value): static
    {
        return $this->assign('external_code', $value);
    }

    public function paymentMethod(string $value): static
    {
        return $this->assign('payment_method', $value);
    }

    public function documentNumber(string $value): static
    {
        return $this->assign('document_number', $value);
    }

    public function chargeAmount(string $value): static
    {
        return $this->assign('charge_amount', $value);
    }

    public function surchargeAmount(string $value): static
    {
        return $this->assign('surcharge_amount', $value);
    }

    public function finalAmount(string $value): static
    {
        return $this->assign('final_amount', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
    }
}
