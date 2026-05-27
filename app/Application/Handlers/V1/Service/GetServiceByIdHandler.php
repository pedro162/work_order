<?php

namespace App\Application\Handlers\V1\Service;

use App\Application\Commands\V1\Service\CreateServiceCommand;
use App\Domain\V1\Service\Repositories\ServiceRepositoryInterface;
use App\Servico as ServiceModel;;

use App\Domain\V1\Service\ValueObjects\ServiceId;

class GetServiceByIdHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateServiceCommand $command): ?ServiceModel
    {
        return $this->repository->findById(new ServiceId($command->getId()));
    }
}
