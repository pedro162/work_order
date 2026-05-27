<?php

namespace App\Application\Services\V1\Seller;

use App\Application\Commands\V1\Seller\CreateSellerCommand;
use App\Application\Handlers\V1\Seller\CreateSellerHandler;
use App\Application\Handlers\V1\Seller\DestroySellerHandler;
use App\Application\Handlers\V1\Seller\GetAllSellerHandler;
use App\Application\Handlers\V1\Seller\GetSellerByIdHandler;
use App\Application\Handlers\V1\Seller\UpdateSellerHandler;
use App\Rca;
use Illuminate\Support\Collection;

class SellerApplicationService implements SellerApplicationServiceInterface
{
    public function __construct(
        private CreateSellerHandler $createSellerHandler,
        protected GetAllSellerHandler $getAllSellerHandler,
        protected UpdateSellerHandler $updateSellerHandler,
        protected GetSellerByIdHandler $getSellerByIdHandler,
        protected DestroySellerHandler $destroySellerHandler
    ) {}

    public function store(
        CreateSellerCommand $command
    ): ?Rca {
        return $this->createSellerHandler->handler($command);
    }

    public function update(
        CreateSellerCommand $command
    ): void {

        $this->updateSellerHandler->handler($command);
    }

    public function getAll(array $data = []): ?Collection
    {
        return $this->getAllSellerHandler->handler($data);
    }

    public function findById(
        CreateSellerCommand $command
    ): ?Rca {

        return $this->getSellerByIdHandler->handler($command);
    }

    public function destroy(
        CreateSellerCommand $command
    ): void {
        $this->destroySellerHandler->handler($command);
    }
}
