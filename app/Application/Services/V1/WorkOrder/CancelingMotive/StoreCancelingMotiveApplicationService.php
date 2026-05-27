<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveHandler;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

class StoreCancelingMotiveApplicationService implements StoreCancelingMotiveApplicationServiceInterface
{
    private CreateCancelingMotiveHandler $createCancelingMotiveHandler;

    public function __construct(CreateCancelingMotiveHandler $createCancelingMotiveHandler)
    {
        $this->createCancelingMotiveHandler = $createCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel
    {
        return $this->createCancelingMotiveHandler->handler($command);
    }
}
