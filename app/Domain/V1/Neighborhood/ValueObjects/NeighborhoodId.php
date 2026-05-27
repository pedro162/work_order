<?php

namespace App\Domain\V1\Neighborhood\ValueObjects;

class NeighborhoodId
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
