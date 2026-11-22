<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderInstallment;

use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Application\Commands\V1\WorkOrderInstallment\CreateWorkOrderInstallmentCommand;

final class CreateWorkOrderInstallmentHandler
{
    public function __construct(
        private readonly WorkOrderInstallmentRepositoryInterface $repository
    ) {
    }

    public function handler(CreateWorkOrderInstallmentCommand $command): WorkOrderInstallment
    {
        $entity = WorkOrderInstallment::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
