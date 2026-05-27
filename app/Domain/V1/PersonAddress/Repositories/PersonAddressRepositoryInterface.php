<?php

namespace App\Domain\V1\PersonAddress\Repositories;

use App\Domain\V1\PersonAddress\Entities\PersonAddress;
use App\Domain\V1\PersonAddress\ValueObjects\PersonAddressId;
use App\Logradouro;

interface PersonAddressRepositoryInterface
{
    public function save(PersonAddress $task): ?Logradouro;
    public function findById(PersonAddressId $id): ?Logradouro;
    public function getAll(array $filter = []): ?array;
    public function update(PersonAddress $parameter): void;
    public function destroy(PersonAddress $parameter): void;
}
