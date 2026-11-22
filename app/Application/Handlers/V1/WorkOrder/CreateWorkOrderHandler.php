<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand;

final class CreateWorkOrderHandler
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {
    }

    public function handler(CreateWorkOrderCommand $command): WorkOrder
    {
        $entity = WorkOrder::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
