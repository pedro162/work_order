<?php

namespace App\Infrastructure\Repositories\Eloquent\WorkOrderItem;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface
as WOInterface;
use App\Domain\V1\WorkOrderItem\ValueObjects\WorkOrderItemId;
use App\Infrastructure\Mappers\V1\WorkOrderItemMapper;
use App\Models\WorkOrderItem as WorkOrderItemModel;
use InvalidArgumentException;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;

final class WorkOrderItemEloquentRepository extends AbstractEloquentRepository implements WOInterface
{
    protected const MODEL = WorkOrderItemModel::class;
    protected const FILTERS = ['work_order_id', 'active'];

    public function __construct(private readonly WorkOrderItemMapper $mapper)
    {
    }

    public function save(WorkOrderItem $entity): WorkOrderItem
    {
        $id = $entity->getId();
        $model = $this->persist($id !== null ? (int)(string)$id : null, $this->mapper->toPersistence($entity));
        return $this->mapper->toDomain($model);
    }

    public function findById(WorkOrderItemId $id): ?WorkOrderItem
    {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(array $filters = [], int $limit = 50): array
    {
        return array_map(fn ($model) => $this->mapper->toDomain($model), $this->listRecords($filters, $limit));
    }

    public function update(WorkOrderItem $entity): WorkOrderItem
    {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException('ID obrigatório para atualizar.');
        }
        return $this->save($entity);
    }

    public function destroy(WorkOrderItemId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<WorkOrderItem>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [];

        $query = WorkOrderItemModel::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, $allowedFilters, true)) {
                throw new InvalidArgumentException(
                    __(
                        'work-ordr-installment.filter_not_allowed',
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
