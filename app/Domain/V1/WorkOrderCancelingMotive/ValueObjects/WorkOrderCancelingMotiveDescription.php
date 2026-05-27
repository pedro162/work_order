<?php

namespace App\Domain\V1\WorkOrderCancelingMotive\ValueObjects;

class WorkOrderCancelingMotiveDescription
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
