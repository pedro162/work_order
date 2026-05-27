<?php

namespace App\Domain\V1\Seller\ValueObjects;

class SellerAccessAllRcas
{
    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, ['yes', 'no'], true)) {
            throw new \InvalidArgumentException('Seller access all RCAs must be either yes or no');
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
