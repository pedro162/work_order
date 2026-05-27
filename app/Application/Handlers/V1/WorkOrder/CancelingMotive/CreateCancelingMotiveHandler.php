<?php

namespace App\Application\Handlers\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\V1\WorkOrderCancelingMotive\Entities\WorkOrderCancelingMotive;
use App\Domain\V1\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class CreateCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        $entity = WorkOrderCancelingMotive::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
