<?php

namespace App\Application\Handlers\V1\Service;

use App\Application\Commands\V1\Service\CreateServiceCommand;
use App\Domain\V1\Service\Entities\Service;
use App\Domain\V1\Service\Repositories\ServiceRepositoryInterface;
use App\Servico as ServiceModel;;

class CreateServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): ?ServiceModel
    {
        $entity = Service::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
