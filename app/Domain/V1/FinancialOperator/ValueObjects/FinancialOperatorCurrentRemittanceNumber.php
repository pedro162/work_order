<?php

namespace App\Domain\V1\FinancialOperator\ValueObjects;

class FinancialOperatorCurrentRemittanceNumber
{
    private string $value;

    public function __construct(string $value)
    {
        if (trim($value) == '') {
            throw new \InvalidArgumentException('The current remittance number cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
