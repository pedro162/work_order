<?php

namespace App\Domain\V1\PaymentPlan\ValueObjects;

class PaymentPlanFirstInstallmentDays
{
    private int $value;

    public function __construct(int $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException('The first installment days should be a positive number');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
