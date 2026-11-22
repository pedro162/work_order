<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrder;

use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;
use App\Application\Commands\V1\WorkOrder\DeleteWorkOrderCommand;

final class DestroyWorkOrderHandler
{
    public function __construct(
        private readonly WorkOrderRepositoryInterface $repository
    ) {
    }

    public function handler(DeleteWorkOrderCommand $command): void
    {
        $this->repository->destroy(new WorkOrderId((string) $command->getId()));
    }
}
