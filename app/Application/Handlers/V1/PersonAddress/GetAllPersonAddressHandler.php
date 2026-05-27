<?php

namespace App\Application\Handlers\V1\PersonAddress;

use App\Domain\V1\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use Illuminate\Support\Collection;

class GetAllPersonAddressHandler
{
    private PersonAddressRepositoryInterface $repository;

    public function __construct(PersonAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(array $data = []): ?Collection
    {
        return collect($this->repository->getAll($data)['registro']) ?? null;
    }
}
