<?php

declare(strict_types=1);

namespace App\Domain\V1\Shared\Entities;

use App\Domain\V1\Shared\ValueObjects\EntityId;

/** Base independente de Laravel. Nulls explícitos preservados para updates. */
abstract class RecordEntity
{
    protected const FIELDS = [];
    protected const REQUIRED_ON_CREATE = [];

    private ?EntityId $id;
    private array $data;

    final protected function __construct(?EntityId $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public static function fromPrimitives(array $data): static
    {
        $id = isset($data['id']) ? new EntityId($data['id']) : null;
        $filtered = [];

        foreach (static::FIELDS as $field) {
            if (array_key_exists($field, $data)) {
                $filtered[$field] = static::normalize($field, $data[$field]);
            }
        }

        if ($id === null) {
            foreach (static::REQUIRED_ON_CREATE as $key) {
                if (!array_key_exists($key, $filtered) || $filtered[$key] === null || $filtered[$key] === '') {
                    throw new \InvalidArgumentException("Campo obrigatório: {$key}");
                }
            }
        }

        return new static($id, $filtered);
    }

    protected static function normalize(string $field, mixed $value): mixed
    {
        return $value;
    }

    public function id(): ?EntityId
    {
        return $this->id;
    }

    public function get(string $field): mixed
    {
        if (!in_array($field, static::FIELDS, true)) {
            throw new \InvalidArgumentException('Campo desconhecido.');
        }
        return $this->data[$field] ?? null;
    }

    public function toPrimitives(): array
    {
        return $this->data;
    }

    public function withChanges(array $changes): static
    {
        return static::fromPrimitives(array_merge($this->data, ['id' => $this->id?->value()], $changes));
    }
}
