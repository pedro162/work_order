<?php

namespace App\Infrastructure\Repositories\Eloquent\WorkOrderInstallment;

use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface
as WOInstallment;
use App\Domain\V1\WorkOrderInstallment\ValueObjects\WorkOrderInstallmentId;
use App\Infrastructure\Mappers\V1\WorkOrderInstallmentMapper;
use App\Models\WorkOrderInstallment as WorkOrderInstallmentModel;
use InvalidArgumentException;
use App\Infrastructure\Repositories\Eloquent\AbstractEloquentRepository;

final class WorkOrderInstallmentEloquentRepository extends AbstractEloquentRepository implements WOInstallment
{
    protected const MODEL = WorkOrderInstallmentModel::class;
    protected const FILTERS = ['work_order_id', 'payment_method', 'active'];

    public function __construct(
        private readonly WorkOrderInstallmentMapper $mapper
    ) {
    }

    public function save(
        WorkOrderInstallment $entity
    ): WorkOrderInstallment {
        $id = $entity->getId();
        $model = $this->persist(
            $id !== null ? (int)(string)$id : null,
            $this->mapper->toPersistence($entity)
        );
        return $this->mapper->toDomain($model);
    }

    public function findById(
        WorkOrderInstallmentId $id
    ): ?WorkOrderInstallment {
        $model = $this->findRecord((int)(string)$id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function getAll(
        array $filters = [],
        int $limit = 50
    ): array {
        return array_map(
            fn ($model) => $this->mapper->toDomain($model),
            $this->listRecords($filters, $limit)
        );
    }

    public function update(
        WorkOrderInstallment $entity
    ): WorkOrderInstallment {
        if ($entity->getId() === null) {
            throw new InvalidArgumentException(
                'ID obrigatório para atualizar.'
            );
        }

        return $this->save($entity);
    }

    public function destroy(WorkOrderInstallmentId $id): void
    {
        $this->deleteRecord((int)(string)$id);
    }

    /**
     * @return PaginatedResult<WorkOrderInstallment>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult {

        $allowedFilters = [];

        $query = WorkOrderInstallmentModel::query();

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
