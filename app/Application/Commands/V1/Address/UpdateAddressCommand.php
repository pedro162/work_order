<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\Address;

use App\Application\Commands\V1\BaseUpdateCommand;

final class UpdateAddressCommand extends BaseUpdateCommand
{
    protected static function fields(): array
    {
        return [
            'person_id' => 'int',
            'type' => 'string',
            'zip_code' => 'string',
            'street' => 'string',
            'number' => 'string',
            'complement' => 'string',
            'neighborhood' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'is_primary' => 'bool',
            'active' => 'bool',
        ];
    }

    public function personId(int $value): static
    {
        return $this->assign('person_id', $value);
    }

    public function type(string $value): static
    {
        return $this->assign('type', $value);
    }

    public function zipCode(string $value): static
    {
        return $this->assign('zip_code', $value);
    }

    public function street(string $value): static
    {
        return $this->assign('street', $value);
    }

    public function number(string $value): static
    {
        return $this->assign('number', $value);
    }

    public function complement(string $value): static
    {
        return $this->assign('complement', $value);
    }

    public function neighborhood(string $value): static
    {
        return $this->assign('neighborhood', $value);
    }

    public function city(string $value): static
    {
        return $this->assign('city', $value);
    }

    public function state(string $value): static
    {
        return $this->assign('state', $value);
    }

    public function country(string $value): static
    {
        return $this->assign('country', $value);
    }

    public function isPrimary(bool $value): static
    {
        return $this->assign('is_primary', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
    }
}
