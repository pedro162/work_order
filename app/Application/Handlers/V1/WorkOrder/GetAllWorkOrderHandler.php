<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllWorkOrderHandler
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
