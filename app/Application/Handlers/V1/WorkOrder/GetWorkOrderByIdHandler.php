<?php

namespace App\Application\Handlers\V1\WorkOrder;

use App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand;
use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;
use App\OrdemServico as WorkOrderModel;

class GetWorkOrderByIdHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository) {}

    public function handler(CreateWorkOrderCommand $command): ?WorkOrderModel
    {
        return $this->repository->findById(new WorkOrderId($command->getId()));
    }
}
