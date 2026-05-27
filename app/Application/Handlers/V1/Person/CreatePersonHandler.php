<?php

namespace App\Application\Handlers\V1\Person;

use App\Application\Commands\V1\Person\CreatePersonCommand;
use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Pessoa;;

class CreatePersonHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): ?Pessoa
    {
        $entity = Person::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
