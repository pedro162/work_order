<?php

namespace App\Domain\V1\Shared\ValueObjects;

use InvalidArgumentException;

abstract readonly class PrimitiveValue
{
    public function __construct(protected string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException(static::class . ' não pode ser vazio.');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
    public function __toString(): string
    {
        return $this->value;
    }
}
