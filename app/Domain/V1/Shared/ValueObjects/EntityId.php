<?php

declare(strict_types=1);

namespace App\Domain\V1\Shared\ValueObjects;

final class EntityId
{
    private int $value;

    public function __construct(int|string $value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false || (int)$value <= 0) {
            throw new \InvalidArgumentException('ID inválido.');
        }

        $this->value = (int)$value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
