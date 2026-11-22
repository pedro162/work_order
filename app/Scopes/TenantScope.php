<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use RuntimeException;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $tenantId = auth()?->user()?->tenant_id;

        if ($tenantId === null) {
            throw new RuntimeException(
                'Tenant não identificado para esta operação.'
            );
        }

        $builder->where(
            $model->qualifyColumn('tenant_id'),
            $tenantId
        );
    }
}
