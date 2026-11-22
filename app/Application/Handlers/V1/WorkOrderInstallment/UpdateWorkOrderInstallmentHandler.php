<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderInstallment;

use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;
use App\Application\Commands\V1\WorkOrderInstallment\UpdateWorkOrderInstallmentCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateWorkOrderInstallmentHandler
{
    public function __construct(
        private readonly WorkOrderInstallmentRepositoryInterface $repository
    ) {
    }

    public function handler(UpdateWorkOrderInstallmentCommand $command): WorkOrderInstallment
    {
        $id = new WorkOrderInstallmentId($command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(WorkOrderInstallment::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = WorkOrderInstallment::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
