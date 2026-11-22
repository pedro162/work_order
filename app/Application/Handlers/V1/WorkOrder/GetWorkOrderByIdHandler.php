<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;

final class GetWorkOrderByIdHandler
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?WorkOrder
    {
        return $this->repository->findById(new WorkOrderId((string) $id));
    }
}
