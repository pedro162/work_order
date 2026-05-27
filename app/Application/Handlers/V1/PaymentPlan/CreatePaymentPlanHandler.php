<?php

namespace App\Application\Handlers\V1\PaymentPlan;

use App\Application\Commands\V1\PaymentPlan\CreatePaymentPlanCommand;
use App\Domain\V1\PaymentPlan\Entities\PaymentPlan;
use App\Domain\V1\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;
use App\PlanoPagamento;;

class CreatePaymentPlanHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): ?PlanoPagamento
    {
        $entity = PaymentPlan::buildEntity($command->getDataProperties());

        return $this->repository->save($entity);
    }
}
