<?php

namespace App\Application\Handlers\V1\PaymentPlan;

use App\Application\Commands\V1\PaymentPlan\CreatePaymentPlanCommand;
use App\Domain\V1\PaymentPlan\Entities\PaymentPlan;
use App\Domain\V1\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;;

class UpdatePaymentPlanHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): void
    {
        $entity = PaymentPlan::buildEntity($command->getDataProperties());
        $this->repository->update($entity);
    }
}
