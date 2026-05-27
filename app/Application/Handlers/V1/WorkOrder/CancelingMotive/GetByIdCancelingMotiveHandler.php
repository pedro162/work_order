<?php

namespace App\Application\Handlers\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Domain\V1\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\Domain\V1\WorkOrderCancelingMotive\ValueObjects\WorkOrderCancelingMotiveId;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class GetByIdCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        return $this->repository->findById(new WorkOrderCancelingMotiveId((string) $command->getId()));
    }
}
