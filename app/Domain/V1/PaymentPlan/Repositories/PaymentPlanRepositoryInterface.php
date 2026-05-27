<?php

namespace App\Domain\V1\PaymentPlan\Repositories;

use App\Domain\V1\PaymentPlan\Entities\PaymentPlan;
use App\Domain\V1\PaymentPlan\ValueObjects\PaymentPlanId;
use App\PlanoPagamento;

interface PaymentPlanRepositoryInterface
{
    public function save(PaymentPlan $task): ?PlanoPagamento;
    public function findById(PaymentPlanId $id): ?PlanoPagamento;
    public function getAll(array $filter = []): ?array;
    public function update(PaymentPlan $parameter): void;
    public function destroy(PaymentPlan $parameter): void;
}
