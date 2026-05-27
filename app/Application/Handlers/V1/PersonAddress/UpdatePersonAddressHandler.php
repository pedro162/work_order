<?php

namespace App\Application\Handlers\V1\PersonAddress;

use App\Application\Commands\V1\PersonAddress\CreatePersonAddressCommand;
use App\Domain\V1\PersonAddress\Entities\PersonAddress;
use App\Domain\V1\PersonAddress\Repositories\PersonAddressRepositoryInterface;;

class UpdatePersonAddressHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonAddressCommand $command): void
    {
        $entity = PersonAddress::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
