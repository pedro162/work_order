<?php

namespace App\Domain\V1\PaymentPlan\ValueObjects;

class PaymentPlanInstallmentIntervalDays
{
    private int $value;

    public function __construct(int $value)
    {
        if ((int) $value < 0) {
            throw new \InvalidArgumentException('The installment days interval field should be a positive number');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
