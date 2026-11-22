<?php

declare(strict_types=1);

namespace App\Application\Commands\V1;

use InvalidArgumentException;

/**
 * Commands não dependem de Eloquent nem de Value Objects do domínio.
 * O controlador deve fornecer dados previamente validados e autorizados.
 */
abstract class BaseWriteCommand
{
    /** @var array<string, mixed> */
    protected array $data = [];

    /** @return array<string, string> field => string|decimal|int|bool */
    abstract protected static function fields(): array;

    /** @return list<string> */
    protected static function requiredFields(): array
    {
        return [];
    }

    public function getDataProperties(): array
    {
        return $this->data;
    }

    protected function assign(string $field, mixed $value): static
    {
        $types = static::fields();

        if (!array_key_exists($field, $types)) {
            throw new InvalidArgumentException(
                __(
                    'application.command.field_not_allowed',
                    ['field' => $field]
                )
            );
        }

        // Neste projeto os Mappers atuais ignoram null; não fingimos que limpou o campo.
        if ($value === null) {
            throw new InvalidArgumentException(
                __('application.command.null_not_supported', ['field' => $field])
            );
        }

        $type = $types[$field];

        switch ($type) {
            case 'bool':
                $parsed = filter_var(
                    $value,
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                );

                if ($parsed === null) {
                    throw new InvalidArgumentException(
                        __('application.command.invalid_boolean', ['field' => $field])
                    );
                }

                $value = $parsed;
                break;
            case 'int':
                if (
                    filter_var(
                        $value,
                        FILTER_VALIDATE_INT,
                        ['options' => ['min_range' => 1]]
                    ) === false
                ) {
                    throw new InvalidArgumentException(
                        __('application.command.invalid_id', ['field' => $field])
                    );
                }

                $value = (int) $value;
                break;
            case 'decimal':
                if (
                    (!is_string($value) && !is_int($value)) ||
                    !preg_match('/^-?\d+(?:\.\d+)?$/D', (string) $value)
                ) {
                    throw new InvalidArgumentException(
                        __('application.command.invalid_decimal', ['field' => $field])
                    );
                }

                $value = (string) $value;
                break;
            default:
                if (!is_string($value)) {
                    throw new InvalidArgumentException(
                        __('application.command.invalid_string', ['field' => $field])
                    );
                }
        }

        $this->data[$field] = $value;
        return $this;
    }

    public static function build(array $data): static
    {
        $command = new static();
        $allowed = static::fields();
        $aliases = [];

        foreach ($allowed as $field => $_type) {
            $aliases[$field] = $field;
            $aliases[lcfirst(str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', $field))
            ))] = $field;
        }

        if ($command instanceof BaseUpdateCommand) {
            $aliases['id'] = 'id';
        }

        foreach ($data as $key => $value) {
            if (!is_string($key) || !array_key_exists($key, $aliases)) {
                throw new InvalidArgumentException(
                    __('application.command.field_not_allowed', ['field' => (string) $key])
                );
            }

            $field = $aliases[$key];

            if ($field === 'id') {
                $command->id($value);
                continue;
            }

            if (array_key_exists($field, $command->data)) {
                throw new InvalidArgumentException(
                    __('application.command.duplicate_field', ['field' => $field])
                );
            }
            $command->assign($field, $value);
        }

        foreach (static::requiredFields() as $field) {
            if (
                !array_key_exists($field, $command->data) ||
                (is_string($command->data[$field]) &&
                    trim($command->data[$field]) === '')
            ) {
                throw new InvalidArgumentException(
                    __('application.command.required', ['field' => $field])
                );
            }
        }
        return $command;
    }
}
