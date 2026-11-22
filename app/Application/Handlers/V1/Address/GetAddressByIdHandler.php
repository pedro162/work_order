<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Address;

use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Domain\V1\Address\Entities\Address;
use App\Domain\V1\Address\ValueObjects\AddressId;

final class GetAddressByIdHandler
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository
    ) {
    }

    public function handler(int $id): ?Address
    {
        return $this->repository->findById(new AddressId($id));
    }
}
