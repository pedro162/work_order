<?php

namespace App\Domain\V1\Parameter\Repositories;

use App\Domain\V1\Parameter\Entities\Parameter;
use App\Domain\V1\Parameter\ValueObjects\ParameterId;

interface ParameterRepositoryInterface
{
    public function save(Parameter $parameter): ?Parameter;
    public function findById(ParameterId $id): ?Parameter;
    public function getAll(array $filter);
}
