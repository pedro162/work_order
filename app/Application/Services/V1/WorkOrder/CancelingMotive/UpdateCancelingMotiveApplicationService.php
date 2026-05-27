<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Handlers\V1\WorkOrder\CancelingMotive\UpdateCancelingMotiveHandler;

class UpdateCancelingMotiveApplicationService implements UpdateCancelingMotiveApplicationServiceInterface
{
    private UpdateCancelingMotiveHandler $updateCancelingMotiveHandler;

    public function __construct(UpdateCancelingMotiveHandler $updateCancelingMotiveHandler)
    {
        $this->updateCancelingMotiveHandler = $updateCancelingMotiveHandler;
    }

    public function handler(CreateCancelingMotiveCommand $command): void
    {
        $this->updateCancelingMotiveHandler->handler($command);
    }
}
