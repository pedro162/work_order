<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Tenant;

use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Domain\V1\Tenant\Entities\Tenant;
use App\Domain\V1\Tenant\ValueObjects\TenantId;
use App\Application\Commands\V1\Tenant\UpdateTenantCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateTenantHandler
{
    public function __construct(
        private readonly TenantRepositoryInterface $repository
    ) {
    }

    public function handler(UpdateTenantCommand $command): Tenant
    {
        $id = new TenantId($command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(Tenant::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = Tenant::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
