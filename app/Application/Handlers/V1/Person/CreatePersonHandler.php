<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Person;

use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Domain\V1\Person\Entities\Person;
use App\Application\Commands\V1\Person\CreatePersonCommand;

final class CreatePersonHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $repository
    ) {
    }

    public function handler(CreatePersonCommand $command): Person
    {
        $entity = Person::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
