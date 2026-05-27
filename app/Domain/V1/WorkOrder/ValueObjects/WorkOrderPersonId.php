<?php

namespace App\Domain\V1\WorkOrder\ValueObjects;

class WorkOrderPersonId
{
    public function __construct(private string $value) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
