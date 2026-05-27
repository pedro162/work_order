<?php

namespace App\Domain\V1\Neighborhood\Repositories;

use App\Bairro as NeiborhoodModel;
use App\Domain\V1\Neighborhood\Entities\Neighborhood;
use App\Domain\V1\Neighborhood\ValueObjects\NeighborhoodId;

interface NeighborhoodRepositoryInterface
{
    public function save(Neighborhood $parameter): ?NeiborhoodModel;

    public function findById(NeighborhoodId $id): ?NeiborhoodModel;

    public function getAll(array $filter): ?array;

    public function update(Neighborhood $parameter): void;

    public function destroy(Neighborhood $parameter): void;
}
