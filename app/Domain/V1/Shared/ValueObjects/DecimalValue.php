<?php

namespace App\Domain\V1\Shared\ValueObjects;

use InvalidArgumentException;

abstract readonly class DecimalValue extends PrimitiveValue
{
    public function __construct(string|int $value)
    {
        $v = (string) $value;

        if (!preg_match('/^-?\d+(?:\.\d+)?$/D', $v)) {
            throw new InvalidArgumentException('Valor decimal inválido: ' . $v);
        }

        parent::__construct($v);
    }
}
