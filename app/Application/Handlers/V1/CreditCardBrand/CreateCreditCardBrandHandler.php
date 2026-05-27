<?php

namespace App\Application\Handlers\V1\CreditCardBrand;

use App\Application\Commands\V1\CreditCardBrand\CreateCreditCardBrandCommand;
use App\BandeiraCartao;
use App\Domain\V1\CreditCardBrand\Entities\CreditCardBrand;
use App\Domain\V1\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;;

class CreateCreditCardBrandHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): ?BandeiraCartao
    {
        $entity = CreditCardBrand::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
