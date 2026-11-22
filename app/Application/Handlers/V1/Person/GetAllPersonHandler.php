<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Person;

use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllPersonHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
