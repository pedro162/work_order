<?php

namespace App\Application\Handlers\V1\WorkOrder\CancelingMotive;

use App\Domain\V1\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCancelingMotiveHandler
{
    private WorkOrderCancelingMotiveRepositoryInterface $repository;

    public function __construct(WorkOrderCancelingMotiveRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
