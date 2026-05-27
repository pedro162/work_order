<?php

namespace App\Application\Services\V1\Seller;

use App\Application\Commands\V1\Seller\CreateSellerCommand;
use App\Rca;
use Illuminate\Support\Collection;

interface SellerApplicationServiceInterface
{
    public function store(
        CreateSellerCommand $command
    ): ?Rca;

    public function findById(
        CreateSellerCommand $command
    ): ?Rca;

    public function update(
        CreateSellerCommand $command
    ): void;

    public function getAll(array $data = []): ?Collection;

    public function destroy(
        CreateSellerCommand $command
    ): void;
}
