<?php

namespace App\Application\Handlers\V1\CreditCardBrand;

use App\Domain\V1\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
