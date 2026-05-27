<?php

namespace App\Application\Handlers\V1\FinancialOperator;

use App\Application\Commands\V1\FinancialOperator\CreateFinancialOperatorCommand;
use App\Domain\V1\FinancialOperator\Entities\FinancialOperator;
use App\Domain\V1\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;;

class DestroyFinancialOperatorHandler
{
    private FinancialOperatorRepositoryInterface $repository;

    public function __construct(FinancialOperatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateFinancialOperatorCommand $command): void
    {
        $entity = FinancialOperator::buildEntity($command->getDataProperties());
        $this->repository->destroy($entity);
    }
}
