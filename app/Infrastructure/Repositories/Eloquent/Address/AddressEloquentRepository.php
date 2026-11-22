<?php

namespace App\Infrastructure\Repositories\Eloquent\Address;

use App\Domain\V1\Address\Entities\Address;
use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Infrastructure\Mappers\V1\AddressMapper;
use App\Models\Address as AddressModel;
use InvalidArgumentException;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;

final class AddressEloquentRepository extends AbstractEloquentRepository implements AddressRepositoryInterface
{
    protected const MODEL = AddressModel::class;
    protected const FILTERS = ['person_id', 'type', 'is_primary', 'active'];

    public function __construct(private readonly AddressMapper $mapper)
    {
    }

    public function save(Address $entity): Address
    {
        $id = $entity->getId();
        $model = $this->persist($id !== null ? (int)(string)$id : null, $this->mapper->toPersistence($entity));
        return $this->mapper->toDomain($model);
    }

    public function findById(AddressId $id): ?Address
    {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(array $filters = [], int $limit = 50): array
    {
        return array_map(fn ($model) => $this->mapper->toDomain($model), $this->listRecords($filters, $limit));
    }

    public function update(Address $entity): Address
    {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException('ID obrigatório para atualizar.');
        }
        return $this->save($entity);
    }

    public function destroy(AddressId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<Address>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [];

        $query = AddressModel::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, $allowedFilters, true)) {
                throw new InvalidArgumentException(
                    __(
                        'address.filter_not_allowed',
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
