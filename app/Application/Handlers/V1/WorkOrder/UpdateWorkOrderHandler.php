<?php

namespace App\Application\Handlers\V1\WorkOrder;

use App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;

class UpdateWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository) {}

    public function handler(CreateWorkOrderCommand $command): void
    {
        $entity = WorkOrder::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
