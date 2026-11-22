<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Tenant;

use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Domain\V1\Tenant\Entities\Tenant;
use App\Application\Commands\V1\Tenant\CreateTenantCommand;

final class CreateTenantHandler
{
    public function __construct(
        private readonly TenantRepositoryInterface $repository
    ) {
    }

    public function handler(CreateTenantCommand $command): Tenant
    {
        $entity = Tenant::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
