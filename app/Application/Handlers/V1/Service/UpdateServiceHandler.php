<?php

namespace App\Application\Handlers\V1\Service;

use App\Application\Commands\V1\Service\CreateServiceCommand;
use App\Domain\V1\Service\Entities\Service;
use App\Domain\V1\Service\Repositories\ServiceRepositoryInterface;;

class UpdateServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): void
    {
        $entity = Service::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
