<?php

namespace App\Application\Handlers\V1\CreditCardBrand;

use App\Application\Commands\V1\CreditCardBrand\CreateCreditCardBrandCommand;
use App\BandeiraCartao;
use App\Domain\V1\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;;

use App\Domain\V1\CreditCardBrand\ValueObjects\CreditCardBrandId;

class GetCreditCardBrandByIdHandler
{
    private CreditCardBrandRepositoryInterface $repository;

    public function __construct(CreditCardBrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateCreditCardBrandCommand $command): ?BandeiraCartao
    {
        return $this->repository->findById(new CreditCardBrandId($command->getId()));
    }
}
