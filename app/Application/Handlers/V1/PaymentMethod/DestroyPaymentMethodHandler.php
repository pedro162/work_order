<?php

namespace App\Application\Handlers\V1\PaymentMethod;

use App\Application\Commands\V1\PaymentMethod\CreatePaymentMethodCommand;
use App\Domain\V1\PaymentMethod\Entities\PaymentMethod;
use App\Domain\V1\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;;

class DestroyPaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
