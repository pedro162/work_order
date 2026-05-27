<?php

namespace App\Application\Handlers\V1\Seller;

use App\Domain\V1\Seller\Repositories\SellerRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllSellerHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
