<?php

namespace App\Application\Handlers\V1\CreditCardBrand;

use App\Application\Commands\V1\CreditCardBrand\CreateCreditCardBrandCommand;
use App\Domain\V1\CreditCardBrand\Entities\CreditCardBrand;
use App\Domain\V1\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;;

class DestroyCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): void
    {
        $entity = CreditCardBrand::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
