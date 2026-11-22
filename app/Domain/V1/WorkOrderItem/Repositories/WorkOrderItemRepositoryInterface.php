<?php

namespace App\Domain\V1\WorkOrderItem\Repositories;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;

interface WorkOrderItemRepositoryInterface
{
    public function save(WorkOrderItem $entity): WorkOrderItem;
    public function findById(WorkOrderItemId $id): ?WorkOrderItem;
    /** @return array<WorkOrderItem> */
    public function getAll(array $filters = [], int $limit = 50): array;
    public function update(WorkOrderItem $entity): WorkOrderItem;
    public function destroy(WorkOrderItemId $id): void;

    /**
     * @return PaginatedResult<WorkOrderItem>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
