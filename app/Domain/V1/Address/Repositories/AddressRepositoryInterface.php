<?php

namespace App\Domain\V1\Address\Repositories;

use App\Domain\V1\Address\Entities\Address;
use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Domain\V1\Shared\Pagination\PaginatedResult;
use App\Domain\V1\Shared\Pagination\PaginationParams;

interface AddressRepositoryInterface
{
    public function save(Address $entity): Address;
    public function findById(AddressId $id): ?Address;
    /** @return array<Address> */
    public function getAll(array $filters = [], int $limit = 50): array;
    public function update(Address $entity): Address;
    public function destroy(AddressId $id): void;

    /**
     * @return PaginatedResult<Address>
     */
    public function paginate(
        PaginationParams $pagination,
        array $filters = []
    ): PaginatedResult;
}
