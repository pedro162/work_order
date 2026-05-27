<?php

namespace App\Domain\V1\WorkOrder\ValueObjects;

class WorkOrderIsBudget
{
    public function __construct(private string $value) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
