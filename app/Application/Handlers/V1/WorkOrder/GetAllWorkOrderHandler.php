<?php

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllWorkOrderHandler
{
    public function __construct(private WorkOrderRepositoryInterface $repository) {}

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
