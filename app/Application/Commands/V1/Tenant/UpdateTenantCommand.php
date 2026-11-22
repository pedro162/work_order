<?php

declare(strict_types=1);

namespace App\Application\Commands\V1\Tenant;

use App\Application\Commands\V1\BaseUpdateCommand;

final class UpdateTenantCommand extends BaseUpdateCommand
{
    protected static function fields(): array
    {
        return [
            'name' => 'string',
            'trade_name' => 'string',
            'slug' => 'string',
            'document' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'active' => 'bool',
        ];
    }

    public function name(string $value): static
    {
        return $this->assign('name', $value);
    }

    public function tradeName(string $value): static
    {
        return $this->assign('trade_name', $value);
    }

    public function slug(string $value): static
    {
        return $this->assign('slug', $value);
    }

    public function document(string $value): static
    {
        return $this->assign('document', $value);
    }

    public function email(string $value): static
    {
        return $this->assign('email', $value);
    }

    public function phone(string $value): static
    {
        return $this->assign('phone', $value);
    }

    public function active(bool $value): static
    {
        return $this->assign('active', $value);
    }
}
