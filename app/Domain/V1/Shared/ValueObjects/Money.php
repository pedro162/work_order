<?php

declare(strict_types=1);

namespace App\Domain\V1\Shared\ValueObjects;

final class Money
{
    private string $value;

    public function __construct(
        int|float|string $value
    ) {
        $value = (string)$value;

        if (!preg_match('/^-?\d+(?:\.\d{1,2})?$/', $value)) {
            throw new \InvalidArgumentException('Valor monetário inválido.');
        }

        $this->value = number_format((float)$value, 2, '.', '');
    }

    public function value(): string
    {
        return $this->value;
    }
}
