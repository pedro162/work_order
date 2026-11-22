<?php

namespace App\Domain\V1\Shared\ValueObjects;

use InvalidArgumentException;

abstract readonly class PositiveId extends PrimitiveValue
{
    public function __construct(int|string $value)
    {
        $v = (string) $value;

        if (!ctype_digit($v) || (int)$v <= 0) {
            throw new InvalidArgumentException('Identificador inválido.');
        }

        parent::__construct($v);
    }

    public function toInt(): int
    {
        return (int)$this->value;
    }
}
