<?php

namespace App\Application\Handlers\V1\FinancialOperator;

use App\Application\Commands\V1\FinancialOperator\CreateFinancialOperatorCommand;
use App\Domain\V1\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use App\OperadorFinanceiro;;

use App\Domain\V1\FinancialOperator\ValueObjects\FinancialOperatorId;

class GetFinancialOperatorByIdHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): ?OperadorFinanceiro
    {
        return $this->repository->findById(new FinancialOperatorId($command->getId()));
    }
}
