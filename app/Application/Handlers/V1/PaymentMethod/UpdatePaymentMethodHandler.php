<?php

namespace App\Application\Handlers\V1\PaymentMethod;

use App\Application\Commands\V1\PaymentMethod\CreatePaymentMethodCommand;
use App\Domain\V1\FinancialOperator\Entities\FinancialOperator;
use App\Domain\V1\PaymentMethod\Entities\PaymentMethod;
use App\Domain\V1\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Domain\V1\PaymentPlan\Entities\PaymentPlan;;

class UpdatePaymentMethodHandler
{
    private PaymentMethodRepositoryInterface $repository;

    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }

    public function syncFinancialOperators(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $financialOperators = $command->getFinanceOperators() ?? [];
        $financialOperators = array_map(
            fn($item) =>  $entity->addFinancialOperator(
                FinancialOperator::buildEntity($item->getDataProperties())
            ),
            $financialOperators
        );

        $this->repository->syncFinancialOperator($entity);
    }

    public function syncPaymentPlans(CreatePaymentMethodCommand $command): void
    {
        $entity = PaymentMethod::buildEntity($command->getDataProperties());
        $paymentPlans = $command->getPaymentPlans() ?? [];
        $paymentPlans = array_map(
            fn($item) =>  $entity->addPaymentPlan(
                PaymentPlan::buildEntity($item->getDataProperties())
            ),
            $paymentPlans
        );

        $this->repository->syncPaymentPlan($entity);
    }
}
