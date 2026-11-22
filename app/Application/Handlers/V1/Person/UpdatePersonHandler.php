<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Person;

use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Application\Commands\V1\Person\UpdatePersonCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdatePersonHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $repository
    ) {
    }

    public function handler(UpdatePersonCommand $command): Person
    {
        $id = new PersonId($command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(Person::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = Person::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
