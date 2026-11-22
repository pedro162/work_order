<?php

namespace App\Domain\V1\Person\Repositories;

use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;

interface PersonRepositoryInterface
{
    public function save(Person $entity): Person;
    public function findById(PersonId $id): ?Person;
    /** @return array<Person> */
    public function getAll(array $filters = [], int $limit = 50): array;
    public function update(Person $entity): Person;
    public function destroy(PersonId $id): void;

    /**
     * @return PaginatedResult<Person>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
