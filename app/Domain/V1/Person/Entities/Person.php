<?php

declare(strict_types=1);

namespace App\Domain\V1\Person\Entities;

use App\Domain\V1\BaseEntity\Entities\TenantAwareEntity;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Domain\V1\Person\ValueObjects\PersonFirstName;
use App\Domain\V1\Person\ValueObjects\PersonLastName;
use App\Domain\V1\Person\ValueObjects\PersonOptionalName;
use App\Domain\V1\Person\ValueObjects\PersonDocument;
use App\Domain\V1\Person\ValueObjects\PersonExtraDocument;
use App\Domain\V1\Person\ValueObjects\PersonBirthDate;
use App\Domain\V1\Person\ValueObjects\PersonGender;
use App\Domain\V1\Person\ValueObjects\PersonType;

final class Person extends TenantAwareEntity
{
    protected ?PersonId $id = null;
    protected ?PersonFirstName $firstName = null;
    protected ?PersonLastName $lastName = null;
    protected ?PersonOptionalName $optionalName = null;
    protected ?PersonDocument $document = null;
    protected ?PersonExtraDocument $extraDocument = null;
    protected ?PersonBirthDate $birthDate = null;
    protected ?PersonGender $gender = null;
    protected ?PersonType $type = null;

    public function id(PersonId $value): static
    {
        $this->id = $value;

        return $this;
    }

    public function getId(): ?PersonId
    {
        return $this->id;
    }

    public function firstName(PersonFirstName $value): static
    {
        $this->firstName = $value;

        return $this;
    }

    public function getFirstName(): ?PersonFirstName
    {
        return $this->firstName;
    }

    public function lastName(PersonLastName $value): static
    {
        $this->lastName = $value;

        return $this;
    }

    public function getLastName(): ?PersonLastName
    {
        return $this->lastName;
    }

    public function optionalName(PersonOptionalName $value): static
    {
        $this->optionalName = $value;

        return $this;
    }

    public function getOptionalName(): ?PersonOptionalName
    {
        return $this->optionalName;
    }

    public function document(PersonDocument $value): static
    {
        $this->document = $value;

        return $this;
    }

    public function getDocument(): ?PersonDocument
    {
        return $this->document;
    }

    public function extraDocument(PersonExtraDocument $value): static
    {
        $this->extraDocument = $value;

        return $this;
    }

    public function getExtraDocument(): ?PersonExtraDocument
    {
        return $this->extraDocument;
    }

    public function birthDate(PersonBirthDate $value): static
    {
        $this->birthDate = $value;

        return $this;
    }

    public function getBirthDate(): ?PersonBirthDate
    {
        return $this->birthDate;
    }

    public function gender(PersonGender $value): static
    {
        $this->gender = $value;

        return $this;
    }

    public function getGender(): ?PersonGender
    {
        return $this->gender;
    }

    public function type(PersonType $value): static
    {
        $this->type = $value;

        return $this;
    }

    public function getType(): ?PersonType
    {
        return $this->type;
    }

    /** Constrói a entidade de domínio a partir de dados primitivos (sem Eloquent). */
    public static function buildEntity(array $data): self
    {
        $entity = new self();

        $mapping = [
            'id' => fn ($value) => $entity->id(new PersonId((int) $value)),
            'first_name' => fn ($value) => $entity->firstName(new PersonFirstName((string) $value)),
            'last_name' => fn ($value) => $entity->lastName(new PersonLastName((string) $value)),
            'optional_name' => fn ($value) => $entity->optionalName(new PersonOptionalName((string) $value)),
            'document' => fn ($value) => $entity->document(new PersonDocument((string) $value)),
            'extra_document' => fn ($value) => $entity->extraDocument(new PersonExtraDocument((string) $value)),
            'birth_date' => fn ($value) => $entity->birthDate(new PersonBirthDate((string) $value)),
            'gender' => fn ($value) => $entity->gender(new PersonGender((string) $value)),
            'type' => fn ($value) => $entity->type(new PersonType((string) $value)),
            'tenant_id' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string) $value)),
            'user_id' => fn ($value) => $entity->userId(new BaseEntityUserId((int) $value)),
            'user_update_id' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((int) $value)),
            'active' => fn ($value) => $entity->active((bool) $value),
        ];

        foreach ($mapping as $key => $setter) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                $setter($data[$key]);
            }
        }

        return $entity;
    }
}
