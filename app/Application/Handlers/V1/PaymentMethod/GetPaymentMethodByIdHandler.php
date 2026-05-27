<?php

namespace App\Application\Handlers\V1\PaymentMethod;

use App\Application\Commands\V1\PaymentMethod\CreatePaymentMethodCommand;
use App\Domain\V1\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\FormaPagamento;;

use App\Domain\V1\PaymentMethod\ValueObjects\PaymentMethodId;

class GetPaymentMethodByIdHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): ?FormaPagamento
    {
        return $this->repository->findById(new PaymentMethodId($command->getId()));
    }
}
