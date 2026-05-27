<?php

namespace App\Application\Handlers\V1\Person;

use App\Application\Commands\V1\Person\CreatePersonCommand;
use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;;

class DestroyPersonHandler
{
    private PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePersonCommand $command): void
    {
        $entity = Person::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
