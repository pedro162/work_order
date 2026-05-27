<?php

namespace App\Domain\V1\FinancialOperator\ValueObjects;

class FinancialOperatorTariffValue
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The tariff value cannot be negative');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
