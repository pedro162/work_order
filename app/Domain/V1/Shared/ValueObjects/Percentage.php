<?php

declare(strict_types=1);

namespace App\Domain\V1\Shared\ValueObjects;

final class Percentage
{
    private string $value;

    public function __construct(int|float|string $value)
    {
        $value = (string)$value;

        if (!preg_match('/^\d+(?:\.\d{1,4})?$/', $value) || (float)$value > 100) {
            throw new \InvalidArgumentException('Percentual inválido.');
        }

        $this->value = number_format((float)$value, 4, '.', '');
    }

    public function value(): string
    {
        return $this->value;
    }
}
