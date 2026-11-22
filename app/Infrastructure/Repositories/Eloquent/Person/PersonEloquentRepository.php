<?php

namespace App\Infrastructure\Repositories\Eloquent\Person;

use App\Domain\V1\Person\Entities\Person;
use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Infrastructure\Mappers\V1\PersonMapper;
use App\Models\Person as PersonModel;
use InvalidArgumentException;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;

final class PersonEloquentRepository extends AbstractEloquentRepository implements PersonRepositoryInterface
{
    protected const MODEL = PersonModel::class;
    protected const FILTERS = ['document', 'type', 'active'];

    public function __construct(private readonly PersonMapper $mapper)
    {
    }

    public function save(Person $entity): Person
    {
        $id = $entity->getId();
        $model = $this->persist($id !== null ? (int)(string)$id : null, $this->mapper->toPersistence($entity));
        return $this->mapper->toDomain($model);
    }

    public function findById(PersonId $id): ?Person
    {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(array $filters = [], int $limit = 50): array
    {
        return array_map(fn ($model) => $this->mapper->toDomain($model), $this->listRecords($filters, $limit));
    }

    public function update(Person $entity): Person
    {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException('ID obrigatório para atualizar.');
        }

        return $this->save($entity);
    }

    public function destroy(PersonId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<Person>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [];

        $query = PersonModel::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, $allowedFilters, true)) {
                throw new InvalidArgumentException(
                    __(
                        'person.filter_not_allowed',
                        ['filter' => $field]
                    )
                );
            }

            if ($value !== null) {
                $query->where($field, $value);
            }
        }

        return $this->paginateQuery(
            $query->orderByDesc('id'),
            $pagination,
            fn ($model) => $this->mapper->toDomain($model)
        );
    }
}
