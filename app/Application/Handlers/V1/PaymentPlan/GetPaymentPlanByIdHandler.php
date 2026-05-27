<?php

namespace App\Application\Handlers\V1\PaymentPlan;

use App\Application\Commands\V1\PaymentPlan\CreatePaymentPlanCommand;
use App\Domain\V1\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;
use App\PlanoPagamento;;

use App\Domain\V1\PaymentPlan\ValueObjects\PaymentPlanId;

class GetPaymentPlanByIdHandler
{
    private PaymentPlanRepositoryInterface $repository;

    public function __construct(PaymentPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreatePaymentPlanCommand $command): ?PlanoPagamento
    {
        return $this->repository->findById(new PaymentPlanId($command->getId()));
    }
}
