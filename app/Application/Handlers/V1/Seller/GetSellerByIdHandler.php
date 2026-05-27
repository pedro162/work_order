<?php

namespace App\Application\Handlers\V1\Seller;

use App\Application\Commands\V1\Seller\CreateSellerCommand;
use App\Domain\V1\Seller\Repositories\SellerRepositoryInterface;
use App\Rca;;

use App\Domain\V1\Seller\ValueObjects\SellerId;

class GetSellerByIdHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateSellerCommand $command): ?Rca
    {
        return $this->repository->findById(new SellerId($command->getId()));
    }
}
