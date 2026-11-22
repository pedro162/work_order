<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Person;

use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\ValueObjects\PersonId;

final class GetPersonByIdHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?Person
    {
        return $this->repository->findById(new PersonId($id));
    }
}
