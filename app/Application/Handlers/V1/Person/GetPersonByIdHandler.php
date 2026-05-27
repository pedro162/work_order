<?php

namespace App\Application\Handlers\V1\Person;

use App\Application\Commands\V1\Person\CreatePersonCommand;
use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Pessoa;;

use App\Domain\V1\Person\ValueObjects\PersonId;

class GetPersonByIdHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): ?Pessoa
    {
        return $this->repository->findById(new PersonId($command->getId()));
    }
}
