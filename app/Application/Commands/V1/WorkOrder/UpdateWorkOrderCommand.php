<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\WorkOrder;

use App\Application\Commands\V1\BaseUpdateCommand;

final class UpdateWorkOrderCommand extends BaseUpdateCommand
{
    protected static function fields(): array
    {
        return [
            'external_code' => 'string',
            'total_amount' => 'decimal',
            'status' => 'string',
            'notes' => 'string',
            'file_path' => 'string',
            'person_id' => 'int',
            'active' => 'bool',
            'final_amount' => 'decimal',
            'discount_amount' => 'decimal',
            'surcharge_percentage' => 'decimal',
            'surcharge_amount' => 'decimal',
            'discount_percentage' => 'decimal',
            'is_billed' => 'bool',
            'billed_at' => 'string',
            'canceled_at' => 'string',
            'completed_at' => 'string',
            'cancel_reason' => 'string',
            'type' => 'string',
            'is_quote' => 'bool',
        ];
    }

    public function externalCode(string $value): static
    {
        return $this->assign('external_code', $value);
    }

    public function totalAmount(string $value): static
    {
        return $this->assign('total_amount', $value);
    }

    public function status(string $value): static
    {
        return $this->assign('status', $value);
    }

    public function notes(string $value): static
    {
        return $this->assign('notes', $value);
    }

    public function filePath(string $value): static
    {
        return $this->assign('file_path', $value);
    }

    public function personId(int $value): static
    {
        return $this->assign('person_id', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
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

    public function isBilled(bool $value): static
    {
        return $this->assign('is_billed', $value);
    }

    public function billedAt(string $value): static
    {
        return $this->assign('billed_at', $value);
    }

    public function canceledAt(string $value): static
    {
        return $this->assign('canceled_at', $value);
    }

    public function completedAt(string $value): static
    {
        return $this->assign('completed_at', $value);
    }

    public function cancelReason(string $value): static
    {
        return $this->assign('cancel_reason', $value);
    }

    public function type(string $value): static
    {
        return $this->assign('type', $value);
    }

    public function isQuote(bool $value): static
    {
        return $this->assign('is_quote', $value);
    }
}
