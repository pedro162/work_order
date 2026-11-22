<?php

namespace App\Infrastructure\Repositories\Eloquent\WorkOrder;

use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Domain\V1\WorkOrder\ValueObjects\WorkOrderId;
use App\Infrastructure\Mappers\V1\WorkOrderMapper;
use App\Models\WorkOrder as WorkOrderModel;
use InvalidArgumentException;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;

final class WorkOrderEloquentRepository extends AbstractEloquentRepository implements WorkOrderRepositoryInterface
{
    protected const MODEL = WorkOrderModel::class;
    protected const FILTERS = ['person_id', 'status', 'type', 'active', 'is_quote', 'is_billed'];

    public function __construct(private readonly WorkOrderMapper $mapper)
    {
    }

    public function save(WorkOrder $entity): WorkOrder
    {
        $id = $entity->getId();
        $model = $this->persist($id !== null ? (int)(string)$id : null, $this->mapper->toPersistence($entity));
        return $this->mapper->toDomain($model);
    }

    public function findById(WorkOrderId $id): ?WorkOrder
    {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(array $filters = [], int $limit = 50): array
    {
        return array_map(fn ($model) => $this->mapper->toDomain($model), $this->listRecords($filters, $limit));
    }

    public function update(WorkOrder $entity): WorkOrder
    {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException('ID obrigatório para atualizar.');
        }
        return $this->save($entity);
    }

    public function destroy(WorkOrderId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<WorkOrder>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [
            'status',
            'person_id',
            'type',
            'active',
            'is_quote',
            'is_billed',
        ];

        $query = WorkOrderModel::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, $allowedFilters, true)) {
                throw new InvalidArgumentException(
                    __(
                        'work-order.filter_not_allowed',
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
