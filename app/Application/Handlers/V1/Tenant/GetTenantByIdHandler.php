<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Tenant;

use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Domain\V1\Tenant\Entities\Tenant;
use App\Domain\V1\Tenant\ValueObjects\TenantId;

final class GetTenantByIdHandler
{
    public function __construct(
        private readonly TenantRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?Tenant
    {
        return $this->repository->findById(new TenantId($id));
    }
}
