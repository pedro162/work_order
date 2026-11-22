<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Tenant;

use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllTenantHandler
{
    public function __construct(
        private readonly TenantRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
