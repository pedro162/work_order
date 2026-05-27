<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;

interface UpdateCancelingMotiveApplicationServiceInterface
{
    public function handler(CreateCancelingMotiveCommand $command): void;
}
