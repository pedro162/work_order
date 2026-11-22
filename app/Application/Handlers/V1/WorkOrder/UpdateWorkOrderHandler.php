<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;
use App\Application\Commands\V1\WorkOrder\UpdateWorkOrderCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateWorkOrderHandler
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {
    }

    public function handler(UpdateWorkOrderCommand $command): WorkOrder
    {
        $id = new WorkOrderId((string) $command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(WorkOrder::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = WorkOrder::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
