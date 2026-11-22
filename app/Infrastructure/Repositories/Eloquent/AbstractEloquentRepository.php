<?php

namespace App\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use App\Domain\V1\Shared\Pagination\PaginationParams;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use Illuminate\Database\Eloquent\Builder;

/** Infra only. Global scopes stay enabled on all queries. */
abstract class AbstractEloquentRepository
{
    /** @var class-string<Model> */
    protected const MODEL = Model::class;
    protected const FILTERS = [];

    protected function persist(?int $id, array $data): Model
    {
        $class = static::MODEL;
        // tenant_id must come from the trusted model creating hook.
        unset($data['tenant_id'], $data['id'], $data['deleted_at']);

        if ($id !== null) {
            $model = $class::query()->findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model->refresh();
        }

        $model = $class::query()->create($data);
        return $model->refresh();
    }

    protected function findRecord(int $id): ?Model
    {
        $class = static::MODEL;
        return $class::query()->find($id);
    }

    protected function listRecords(array $filters, int $limit): array
    {
        $class = static::MODEL;
        $query = $class::query();

        foreach ($filters as $field => $value) {
            if (!in_array($field, static::FILTERS, true)) {
                throw new InvalidArgumentException("Filtro não permitido: {$field}");
            }

            $query->where($field, $value);
        }

        return $query->orderByDesc('id')->limit(max(1, min($limit, 100)))->get()->all();
    }

    protected function deleteRecord(int $id): void
    {
        $class = static::MODEL;
        $class::query()->findOrFail($id)->delete();
    }

    /**
     * @template TEntity
     *
     * @param callable(Model): TEntity $map
     * @return PaginatedResult<TEntity>
     */
    protected function paginateQuery(
        Builder $query,
        PaginationParams $pagination,
        callable $map
    ): PaginatedResult {
        $result = $query->paginate(
            perPage: $pagination->perPage,
            page: $pagination->page
        );

        return new PaginatedResult(
            items: $result->getCollection()
                ->map($map)
                ->values()
                ->all(),
            total: $result->total(),
            currentPage: $result->currentPage(),
            perPage: $result->perPage(),
            lastPage: $result->lastPage(),
        );
    }
}
