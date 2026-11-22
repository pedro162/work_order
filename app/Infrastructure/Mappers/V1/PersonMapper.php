<?php

declare(strict_types=1);

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\Person\Entities\Person;
use App\Models\Person as PersonModel;

final class PersonMapper
{
    public function toDomain(PersonModel $model): Person
    {
        return Person::buildEntity($model->getAttributes());
    }

    /** Retorna apenas os atributos explicitamente definidos na Entity. */
    public function toPersistence(Person $entity): array
    {
        $attributes = [
            'first_name' => $entity->getFirstName(),
            'last_name' => $entity->getLastName(),
            'optional_name' => $entity->getOptionalName(),
            'document' => $entity->getDocument(),
            'extra_document' => $entity->getExtraDocument(),
            'birth_date' => $entity->getBirthDate(),
            'gender' => $entity->getGender(),
            'type' => $entity->getType(),
            'user_id' => $entity->getUserId(),
            'user_update_id' => $entity->getUserUpdateId(),
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
