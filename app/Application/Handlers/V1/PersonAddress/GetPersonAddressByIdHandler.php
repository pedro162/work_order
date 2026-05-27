<?php

namespace App\Application\Handlers\V1\PersonAddress;

use App\Application\Commands\V1\PersonAddress\CreatePersonAddressCommand;
use App\Domain\V1\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use App\Logradouro;;

use App\Domain\V1\PersonAddress\ValueObjects\PersonAddressId;

class GetPersonAddressByIdHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonAddressCommand $command): ?Logradouro
    {
        return $this->repository->findById(new PersonAddressId($command->getId()));
    }
}
