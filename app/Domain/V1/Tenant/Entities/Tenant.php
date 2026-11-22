<?php

namespace App\Domain\V1\Tenant\Entities;

use App\Domain\V1\BaseEntity\Entities\BaseEntity;
use App\Domain\V1\Tenant\ValueObjects\TenantId;
use App\Domain\V1\Tenant\ValueObjects\TenantName;
use App\Domain\V1\Tenant\ValueObjects\TenantTradeName;
use App\Domain\V1\Tenant\ValueObjects\TenantSlug;
use App\Domain\V1\Tenant\ValueObjects\TenantDocument;
use App\Domain\V1\Tenant\ValueObjects\TenantEmail;
use App\Domain\V1\Tenant\ValueObjects\TenantPhone;

class Tenant extends BaseEntity
{
    protected ?TenantId $id = null;
    protected ?TenantName $name = null;
    protected ?TenantTradeName $tradeName = null;
    protected ?TenantSlug $slug = null;
    protected ?TenantDocument $document = null;
    protected ?TenantEmail $email = null;
    protected ?TenantPhone $phone = null;

    public function id(TenantId $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getId(): ?TenantId
    {
        return $this->id;
    }

    public function name(TenantName $value): static
    {
        $this->name = $value;
        return $this;
    }

    public function getName(): ?TenantName
    {
        return $this->name;
    }

    public function tradeName(TenantTradeName $value): static
    {
        $this->tradeName = $value;
        return $this;
    }

    public function getTradeName(): ?TenantTradeName
    {
        return $this->tradeName;
    }

    public function slug(TenantSlug $value): static
    {
        $this->slug = $value;
        return $this;
    }

    public function getSlug(): ?TenantSlug
    {
        return $this->slug;
    }

    public function document(TenantDocument $value): static
    {
        $this->document = $value;
        return $this;
    }

    public function getDocument(): ?TenantDocument
    {
        return $this->document;
    }

    public function email(TenantEmail $value): static
    {
        $this->email = $value;
        return $this;
    }

    public function getEmail(): ?TenantEmail
    {
        return $this->email;
    }

    public function phone(TenantPhone $value): static
    {
        $this->phone = $value;
        return $this;
    }

    public function getPhone(): ?TenantPhone
    {
        return $this->phone;
    }


    /** Hydration only; map scalar values to typed Value Objects. */
    public static function buildEntity(array $data): self
    {
        $entity = new self();
        $map = [
            'id' => fn ($value) => $entity->id(new TenantId((int) $value)),
            'name' => fn ($value) => $entity->name(new TenantName((string) $value)),
            'trade_name' => fn ($value) => $entity->tradeName(new TenantTradeName((string) $value)),
            'slug' => fn ($value) => $entity->slug(new TenantSlug((string) $value)),
            'document' => fn ($value) => $entity->document(new TenantDocument((string) $value)),
            'email' => fn ($value) => $entity->email(new TenantEmail((string) $value)),
            'phone' => fn ($value) => $entity->phone(new TenantPhone((string) $value)),
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
