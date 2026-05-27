<?php

namespace App\Domain\V1\WorkOrder\ValueObjects;

class WorkOrderTotalValue
{
    public function __construct(private float $value) {}

    public function toFloat(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
