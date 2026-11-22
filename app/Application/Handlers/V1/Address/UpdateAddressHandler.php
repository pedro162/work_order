<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Address;

use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Domain\V1\Address\Entities\Address;
use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Application\Commands\V1\Address\UpdateAddressCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateAddressHandler
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository
    ) {
    }

    public function handler(UpdateAddressCommand $command): Address
    {
        $id = new AddressId($command->getId());
        if ($this->repository->findById($id) === null) {
            throw (new ModelNotFoundException())->setModel(Address::class, [$command->getId()]);
        }

        // Entidade parcial: o Mapper atual envia somente os campos presentes.
        // Campos null são rejeitados pelo Command até existir suporte a limpeza explícita.
        $entity = Address::buildEntity($command->getDataProperties());
        return $this->repository->update($entity);
    }
}
