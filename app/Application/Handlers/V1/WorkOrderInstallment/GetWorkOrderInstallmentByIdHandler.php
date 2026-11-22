<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderInstallment;

use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;

final class GetWorkOrderInstallmentByIdHandler
{
    public function __construct(
        private readonly WorkOrderInstallmentRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?WorkOrderInstallment
    {
        return $this->repository->findById(new WorkOrderInstallmentId($id));
    }
}
