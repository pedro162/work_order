<?php

declare(strict_types=1);

namespace App\Application\Commands\V1;

use InvalidArgumentException;

abstract class BaseDeleteCommand
{
    private ?int $recordId = null;

    public function id(int|string $id): static
    {
        if (
            filter_var(
                $id,
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 1]]
            ) === false
        ) {
            throw new InvalidArgumentException(
                __('application.command.invalid_id', ['field' => 'id'])
            );
        }

        $this->recordId = (int) $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->recordId
            ?? throw new InvalidArgumentException(
                __('application.command.required', ['field' => 'id'])
            );
    }

    public static function build(array $data): static
    {
        foreach (array_keys($data) as $key) {
            if ($key !== 'id') {
                throw new InvalidArgumentException(__(
                    'application.command.field_not_allowed',
                    ['field' => (string) $key]
                ));
            }
        }

        return (new static())->id($data['id'] ?? '');
    }

    public function getDataProperties(): array
    {
        return ['id' => $this->getId()];
    }
}
