<?php

namespace App\Application\Handlers\V1\Seller;

use App\Application\Commands\V1\Seller\CreateSellerCommand;
use App\Domain\V1\Seller\Entities\Seller;
use App\Domain\V1\Seller\Repositories\SellerRepositoryInterface;
use App\Rca;;

class CreateSellerHandler
{
    private SellerRepositoryInterface $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateSellerCommand $command): ?Rca
    {
        $entity = Seller::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
