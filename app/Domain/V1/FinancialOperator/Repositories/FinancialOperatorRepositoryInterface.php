<?php

namespace App\Domain\V1\FinancialOperator\Repositories;

use App\Domain\V1\FinancialOperator\Entities\FinancialOperator;
use App\Domain\V1\FinancialOperator\ValueObjects\FinancialOperatorId;
use App\OperadorFinanceiro;

interface FinancialOperatorRepositoryInterface
{
    public function save(FinancialOperator $task): ?OperadorFinanceiro;
    public function findById(FinancialOperatorId $id): ?OperadorFinanceiro;
    public function getAll(array $filter = []): ?array;
    public function update(FinancialOperator $parameter): void;
    public function destroy(FinancialOperator $parameter): void;
}
