<?php

namespace App\Domain\V1\WorkOrder\Repositories;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;

interface WorkOrderRepositoryInterface
{
    public function save(WorkOrder $entity): WorkOrder;

    public function findById(WorkOrderId $id): ?WorkOrder;

    /** @return array<WorkOrder> */
    public function getAll(array $filters = [], int $limit = 50): array;

    public function update(WorkOrder $entity): WorkOrder;

    public function destroy(WorkOrderId $id): void;

    /**
     * @return PaginatedResult<WorkOrder>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
