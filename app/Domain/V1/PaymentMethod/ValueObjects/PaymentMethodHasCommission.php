<?php

namespace App\Domain\V1\PaymentMethod\ValueObjects;

class PaymentMethodHasCommission
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('The commission field cannot be empty');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
