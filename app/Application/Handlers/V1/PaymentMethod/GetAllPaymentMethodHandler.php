<?php

namespace App\Application\Handlers\V1\PaymentMethod;

use App\Domain\V1\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
