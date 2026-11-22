<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Tenant;

use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Domain\V1\Tenant\ValueObjects\TenantId;
use App\Application\Commands\V1\Tenant\DeleteTenantCommand;

final class DestroyTenantHandler
{
    public function __construct(
        private readonly TenantRepositoryInterface $repository
    ) {
    }

    public function handler(DeleteTenantCommand $command): void
    {
        $this->repository->destroy(new TenantId($command->getId()));
    }
}
