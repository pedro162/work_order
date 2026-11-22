<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderItem;

use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllWorkOrderItemHandler
{
    public function __construct(
        private readonly WorkOrderItemRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
