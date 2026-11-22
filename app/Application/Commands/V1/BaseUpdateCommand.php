<?php

declare(strict_types=1);

namespace App\Application\Commands\V1;

use InvalidArgumentException;

abstract class BaseUpdateCommand extends BaseWriteCommand
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

    public function getDataProperties(): array
    {
        return [
            'id' => $this->getId(),
            ...parent::getDataProperties()
        ];
    }
}
