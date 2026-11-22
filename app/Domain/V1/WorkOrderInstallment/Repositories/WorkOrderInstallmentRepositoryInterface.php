<?php

namespace App\Domain\V1\WorkOrderInstallment\Repositories;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;

interface WorkOrderInstallmentRepositoryInterface
{
    public function save(WorkOrderInstallment $entity): WorkOrderInstallment;
    public function findById(WorkOrderInstallmentId $id): ?WorkOrderInstallment;
    /** @return array<WorkOrderInstallment> */
    public function getAll(array $filters = [], int $limit = 50): array;
    public function update(WorkOrderInstallment $entity): WorkOrderInstallment;
    public function destroy(WorkOrderInstallmentId $id): void;

    /**
     * @return PaginatedResult<WorkOrderInstallment>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
