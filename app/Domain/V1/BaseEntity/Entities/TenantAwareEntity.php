<?php

namespace App\Domain\V1\BaseEntity\Entities;

use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityTenantId;
use App\Domain\V1\BaseEntity\ValueObjects\BaseEntityUserId;

abstract class TenantAwareEntity extends BaseEntity
{
    protected ?BaseEntityTenantId $tenantId = null;

    protected ?BaseEntityUserId $userId = null;

    protected ?BaseEntityUserId $userUpdateId = null;

    public function tenantId(BaseEntityTenantId $tenantId): static
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    public function getTenantId(): ?BaseEntityTenantId
    {
        return $this->tenantId;
    }

    public function userId(BaseEntityUserId $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): ?BaseEntityUserId
    {
        return $this->userId;
    }

    public function userUpdateId(BaseEntityUserId $userUpdateId): static
    {
        $this->userUpdateId = $userUpdateId;

        return $this;
    }

    public function getUserUpdateId(): ?BaseEntityUserId
    {
        return $this->userUpdateId;
    }
}
