<?php

namespace App\Domain\V1\Service\Repositories;

use App\Domain\V1\Service\Entities\Service;
use App\Domain\V1\Service\ValueObjects\ServiceId;
use App\Servico;

interface ServiceRepositoryInterface
{
    public function save(Service $task): ?Servico;
    public function findById(ServiceId $id): ?Servico;
    public function getAll(array $filter = []): ?array;
    public function update(Service $parameter): void;
    public function destroy(Service $parameter): void;
}
