<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderItem;

use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;
use App\Application\Commands\V1\WorkOrderItem\DeleteWorkOrderItemCommand;

final class DestroyWorkOrderItemHandler
{
    public function __construct(
        private readonly WorkOrderItemRepositoryInterface $repository
    ) {
    }

    public function handler(DeleteWorkOrderItemCommand $command): void
    {
        $this->repository->destroy(new WorkOrderItemId($command->getId()));
    }
}
