<?php

namespace App\Domain\V1\WorkOrder\ValueObjects;

class WorkOrdercancelReason
{
    public function __construct(private string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
