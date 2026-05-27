<?php

namespace App\Domain\V1\Service\ValueObjects;

class ServiceValue
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('The service value should be a positive number');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
