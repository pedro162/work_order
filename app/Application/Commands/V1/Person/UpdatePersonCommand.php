<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\Person;

use App\Application\Commands\V1\BaseUpdateCommand;

final class UpdatePersonCommand extends BaseUpdateCommand
{
    protected static function fields(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'optional_name' => 'string',
            'document' => 'string',
            'extra_document' => 'string',
            'birth_date' => 'string',
            'gender' => 'string',
            'type' => 'string',
            'active' => 'bool',
        ];
    }

    public function firstName(string $value): static
    {
        return $this->assign('first_name', $value);
    }

    public function lastName(string $value): static
    {
        return $this->assign('last_name', $value);
    }

    public function optionalName(string $value): static
    {
        return $this->assign('optional_name', $value);
    }

    public function document(string $value): static
    {
        return $this->assign('document', $value);
    }

    public function extraDocument(string $value): static
    {
        return $this->assign('extra_document', $value);
    }

    public function birthDate(string $value): static
    {
        return $this->assign('birth_date', $value);
    }

    public function gender(string $value): static
    {
        return $this->assign('gender', $value);
    }

    public function type(string $value): static
    {
        return $this->assign('type', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
    }
}
