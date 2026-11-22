<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderInstallment;

use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllWorkOrderInstallmentHandler
{
    public function __construct(
        private readonly WorkOrderInstallmentRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
