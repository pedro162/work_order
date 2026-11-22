<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Address;

use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use Illuminate\Support\Collection;

final class GetAllAddressHandler
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository
    ) {
    }

    public function handler(array $filters = [], int $limit = 50): Collection
    {
        return collect($this->repository->getAll($filters, $limit));
    }
}
