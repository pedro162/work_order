<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderItem;

use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;
use App\Application\Commands\V1\WorkOrderItem\UpdateWorkOrderItemCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateWorkOrderItemHandler
{
    public function __construct(
        private readonly WorkOrderItemRepositoryInterface $repository
    ) {
    }

    public function handler(UpdateWorkOrderItemCommand $command): WorkOrderItem
    {
        $id = new WorkOrderItemId($command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(WorkOrderItem::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = WorkOrderItem::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
