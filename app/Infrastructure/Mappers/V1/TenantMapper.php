<?php

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\Tenant\Entities\Tenant;
use App\Models\Tenant as TenantModel;

final class TenantMapper
{
    public function toDomain(TenantModel $model): Tenant
    {
        return Tenant::buildEntity($model->getAttributes());
    }

    public function toPersistence(Tenant $entity): array
    {
        $attributes = [
            'name' => $entity->getName(),
            'trade_name' => $entity->getTradeName(),
            'slug' => $entity->getSlug(),
            'document' => $entity->getDocument(),
            'email' => $entity->getEmail(),
            'phone' => $entity->getPhone(),
            'active' => $entity->getActive(),
        ];

        $data = [];

        foreach ($attributes as $key => $value) {
            if ($value !== null) {
                $data[$key] = (string) $value;
            }
        }

        if ($entity->getActive() !== null) {
            $data['active'] = $entity->getActive();
        }

        return $data;
    }
}
