<?php

namespace App\Application\Handlers\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\V1\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\V1\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;

class UpdateCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): void
    {
        $entity = WorkOrderCancelingMotive::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
