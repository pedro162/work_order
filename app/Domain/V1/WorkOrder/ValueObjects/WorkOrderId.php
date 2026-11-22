<?php

declare(strict_types=1);

namespace App\Domain\V1\WorkOrder\ValueObjects;

use InvalidArgumentException;

final readonly class WorkOrderId
{
    private string $value;

    public function __construct(int|string $value)
    {
        $normalizedValue = (string) $value;

        if (
            !preg_match('/^[1-9][0-9]*$/', $normalizedValue)
        ) {
            throw new InvalidArgumentException(
                'Invalid work order identifier.'
            );
        }

        $this->value = $normalizedValue;
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
