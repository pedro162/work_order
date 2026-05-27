<?php

namespace App\Application\Handlers\V1\WorkOrder;

use App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\OrdemServico as WorkOrderModel;

class CreateWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository) {}

    public function handler(CreateWorkOrderCommand $command): ?WorkOrderModel
    {
        $entity = WorkOrder::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
