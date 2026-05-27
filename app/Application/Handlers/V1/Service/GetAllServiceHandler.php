<?php

namespace App\Application\Handlers\V1\Service;

use App\Domain\V1\Service\Repositories\ServiceRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllServiceHandler
{
    private ServiceRepositoryInterface $repository;

    public function __construct(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
