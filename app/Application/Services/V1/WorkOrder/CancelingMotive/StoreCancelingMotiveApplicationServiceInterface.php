<?php

namespace App\Application\Services\WorkOrder\CancelingMotive;

use App\Application\Commands\V1\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\MotivoCancelamentoOrdemServico as CancelingMotiveModel;

interface StoreCancelingMotiveApplicationServiceInterface
{
    public function handler(CreateCancelingMotiveCommand $command): ?CancelingMotiveModel;
}
