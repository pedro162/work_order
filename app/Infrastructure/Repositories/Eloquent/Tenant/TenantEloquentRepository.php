<?php

namespace App\Infrastructure\Repositories\Eloquent\Tenant;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\Tenant\Entities\Tenant;
use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Domain\V1\Tenant\ValueObjects\TenantId;
use App\Infrastructure\Mappers\V1\TenantMapper;
use App\Models\Tenant as TenantModel;
use InvalidArgumentException;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;

final class TenantEloquentRepository extends AbstractEloquentRepository implements TenantRepositoryInterface
{
    protected const MODEL = TenantModel::class;
    protected const FILTERS = ['slug', 'document', 'active'];

    public function __construct(private readonly TenantMapper $mapper)
    {
    }

    public function save(Tenant $entity): Tenant
    {
        $id = $entity->getId();
        $model = $this->persist($id !== null ? (int)(string)$id : null, $this->mapper->toPersistence($entity));
        return $this->mapper->toDomain($model);
    }

    public function findById(TenantId $id): ?Tenant
    {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(array $filters = [], int $limit = 50): array
    {
        return array_map(fn ($model) => $this->mapper->toDomain($model), $this->listRecords($filters, $limit));
    }

    public function update(Tenant $entity): Tenant
    {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException('ID obrigatório para atualizar.');
        }
        return $this->save($entity);
    }

    public function destroy(TenantId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<Tenant>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [];

        $query = TenantModel::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, $allowedFilters, true)) {
                throw new InvalidArgumentException(
                    __(
                        'tenant.filter_not_allowed',
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
