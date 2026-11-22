<?php

namespace App\Domain\V1\Address\Entities;

use App\Domain\V1\BaseEntity\Entities\TenantAwareEntity;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityUserId;
use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Domain\V1\Address\ValueObjects\AddressPersonId;
use App\Domain\V1\Address\ValueObjects\AddressType;
use App\Domain\V1\Address\ValueObjects\AddressZipCode;
use App\Domain\V1\Address\ValueObjects\AddressStreet;
use App\Domain\V1\Address\ValueObjects\AddressNumber;
use App\Domain\V1\Address\ValueObjects\AddressComplement;
use App\Domain\V1\Address\ValueObjects\AddressNeighborhood;
use App\Domain\V1\Address\ValueObjects\AddressCity;
use App\Domain\V1\Address\ValueObjects\AddressState;
use App\Domain\V1\Address\ValueObjects\AddressCountry;

class Address extends TenantAwareEntity
{
    protected ?AddressId $id = null;
    protected ?AddressPersonId $personId = null;
    protected ?AddressType $type = null;
    protected ?AddressZipCode $zipCode = null;
    protected ?AddressStreet $street = null;
    protected ?AddressNumber $number = null;
    protected ?AddressComplement $complement = null;
    protected ?AddressNeighborhood $neighborhood = null;
    protected ?AddressCity $city = null;
    protected ?AddressState $state = null;
    protected ?AddressCountry $country = null;
    protected ?bool $isPrimary = null;

    public function id(AddressId $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getId(): ?AddressId
    {
        return $this->id;
    }

    public function personId(AddressPersonId $value): static
    {
        $this->personId = $value;
        return $this;
    }

    public function getPersonId(): ?AddressPersonId
    {
        return $this->personId;
    }

    public function type(AddressType $value): static
    {
        $this->type = $value;
        return $this;
    }

    public function getType(): ?AddressType
    {
        return $this->type;
    }

    public function zipCode(AddressZipCode $value): static
    {
        $this->zipCode = $value;
        return $this;
    }

    public function getZipCode(): ?AddressZipCode
    {
        return $this->zipCode;
    }

    public function street(AddressStreet $value): static
    {
        $this->street = $value;
        return $this;
    }

    public function getStreet(): ?AddressStreet
    {
        return $this->street;
    }

    public function number(AddressNumber $value): static
    {
        $this->number = $value;
        return $this;
    }

    public function getNumber(): ?AddressNumber
    {
        return $this->number;
    }

    public function complement(AddressComplement $value): static
    {
        $this->complement = $value;
        return $this;
    }

    public function getComplement(): ?AddressComplement
    {
        return $this->complement;
    }

    public function neighborhood(AddressNeighborhood $value): static
    {
        $this->neighborhood = $value;
        return $this;
    }

    public function getNeighborhood(): ?AddressNeighborhood
    {
        return $this->neighborhood;
    }

    public function city(AddressCity $value): static
    {
        $this->city = $value;
        return $this;
    }

    public function getCity(): ?AddressCity
    {
        return $this->city;
    }

    public function state(AddressState $value): static
    {
        $this->state = $value;
        return $this;
    }

    public function getState(): ?AddressState
    {
        return $this->state;
    }

    public function country(AddressCountry $value): static
    {
        $this->country = $value;
        return $this;
    }

    public function getCountry(): ?AddressCountry
    {
        return $this->country;
    }

    public function isPrimary(bool $value): static
    {
        $this->isPrimary = $value;
        return $this;
    }

    public function getIsPrimary(): ?bool
    {
        return $this->isPrimary;
    }

    /** Hydration only; map scalar values to typed Value Objects. */
    public static function buildEntity(array $data): self
    {
        $entity = new self();
        $map = [
            'id' => fn ($value) => $entity->id(new AddressId((int) $value)),
            'person_id' => fn ($value) => $entity->personId(new AddressPersonId((int) $value)),
            'type' => fn ($value) => $entity->type(new AddressType((string) $value)),
            'zip_code' => fn ($value) => $entity->zipCode(new AddressZipCode((string) $value)),
            'street' => fn ($value) => $entity->street(new AddressStreet((string) $value)),
            'number' => fn ($value) => $entity->number(new AddressNumber((string) $value)),
            'complement' => fn ($value) => $entity->complement(new AddressComplement((string) $value)),
            'neighborhood' => fn ($value) => $entity->neighborhood(new AddressNeighborhood((string) $value)),
            'city' => fn ($value) => $entity->city(new AddressCity((string) $value)),
            'state' => fn ($value) => $entity->state(new AddressState((string) $value)),
            'country' => fn ($value) => $entity->country(new AddressCountry((string) $value)),
            'is_primary' => fn ($value) => $entity->isPrimary((bool) $value),
            'tenant_id' => fn ($value) => $entity->tenantId(new BaseEntityTenantId((string) $value)),
            'user_id' => fn ($value) => $entity->userId(new BaseEntityUserId((int) $value)),
            'user_update_id' => fn ($value) => $entity->userUpdateId(new BaseEntityUserId((int) $value)),
            'active' => fn ($value) => $entity->active((bool) $value),
        ];

        foreach ($map as $key => $setter) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                $setter($data[$key]);
            }
        }

        return $entity;
    }
}
