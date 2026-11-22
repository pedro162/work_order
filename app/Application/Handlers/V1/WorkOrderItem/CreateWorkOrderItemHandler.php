<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderItem;

use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Application\Commands\V1\WorkOrderItem\CreateWorkOrderItemCommand;

final class CreateWorkOrderItemHandler
{
    public function __construct(
        private readonly WorkOrderItemRepositoryInterface $repository
    ) {
    }

    public function handler(CreateWorkOrderItemCommand $command): WorkOrderItem
    {
        $entity = WorkOrderItem::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
