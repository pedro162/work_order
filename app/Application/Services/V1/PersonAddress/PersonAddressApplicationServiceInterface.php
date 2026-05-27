<?php

namespace App\Application\Services\PersonAddress;

use App\Application\Commands\V1\PersonAddress\CreatePersonAddressCommand;
use App\Logradouro;
use Illuminate\Support\Collection;

interface PersonAddressApplicationServiceInterface
{
    public function store(
        CreatePersonAddressCommand $command
    ): ?Logradouro;

    public function findById(
        CreatePersonAddressCommand $command
    ): ?Logradouro;

    public function update(
        CreatePersonAddressCommand $command
    ): void;

    public function destroy(
        CreatePersonAddressCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;
}
