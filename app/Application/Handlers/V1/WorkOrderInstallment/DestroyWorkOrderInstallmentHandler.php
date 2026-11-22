<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\WorkOrderInstallment;

use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;
use App\Application\Commands\V1\WorkOrderInstallment\DeleteWorkOrderInstallmentCommand;

final class DestroyWorkOrderInstallmentHandler
{
    public function __construct(
        private readonly WorkOrderInstallmentRepositoryInterface $repository
    ) {
    }

    public function handler(DeleteWorkOrderInstallmentCommand $command): void
    {
        $this->repository->destroy(new WorkOrderInstallmentId($command->getId()));
    }
}
