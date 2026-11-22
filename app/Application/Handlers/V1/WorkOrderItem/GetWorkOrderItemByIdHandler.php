<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderItem;

use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;

final class GetWorkOrderItemByIdHandler
{
    public function __construct(
        private readonly WorkOrderItemRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?WorkOrderItem
    {
        return $this->repository->findById(new WorkOrderItemId($id));
    }
}
