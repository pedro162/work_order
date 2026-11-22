<?php

declare(strict_types=1);

namespace App\Domain\V1\Shared\ValueObjects;

final class Slug
{
    private string $value;
    public function __construct(string $value)
    {
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException('Slug inválido.');
        } $this->value = $value;
    }
    public function value(): string
    {
        return $this->value;
    }
}
