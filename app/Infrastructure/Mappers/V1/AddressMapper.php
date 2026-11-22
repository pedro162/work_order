<?php

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\Address\Entities\Address;
use App\Models\Address as AddressModel;

final class AddressMapper
{
    public function toDomain(AddressModel $model): Address
    {
        return Address::buildEntity($model->getAttributes());
    }

    public function toPersistence(Address $entity): array
    {
        $attributes = [
            'person_id' => $entity->getPersonId(),
            'type' => $entity->getType(),
            'zip_code' => $entity->getZipCode(),
            'street' => $entity->getStreet(),
            'number' => $entity->getNumber(),
            'complement' => $entity->getComplement(),
            'neighborhood' => $entity->getNeighborhood(),
            'city' => $entity->getCity(),
            'state' => $entity->getState(),
            'country' => $entity->getCountry(),
            'is_primary' => $entity->getIsPrimary(),
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

        // tenant_id é controlado pela BelongsToTenant, não pelo payload.
        return $data;
    }
}
