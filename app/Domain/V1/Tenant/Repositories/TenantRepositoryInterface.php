<?php

namespace App\Domain\V1\Tenant\Repositories;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\Tenant\Entities\Tenant;
use App\Domain\V1\Tenant\ValueObjects\TenantId;

interface TenantRepositoryInterface
{
    public function save(Tenant $entity): Tenant;
    public function findById(TenantId $id): ?Tenant;
    /** @return array<Tenant> */
    public function getAll(array $filters = [], int $limit = 50): array;
    public function update(Tenant $entity): Tenant;
    public function destroy(TenantId $id): void;

    /**
     * @return PaginatedResult<Tenant>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
