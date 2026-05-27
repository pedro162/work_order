<?php

namespace App\Domain\V1\PersonAddress\ValueObjects;

class PersonAddressNeighborHood
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
