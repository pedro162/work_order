<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Address;

use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Domain\V1\Address\Entities\Address;
use App\Application\Commands\V1\Address\CreateAddressCommand;

final class CreateAddressHandler
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository
    ) {
    }

    public function handler(CreateAddressCommand $command): Address
    {
        $entity = Address::buildEntity($command->getDataProperties());
        return $this->repository->save($entity);
    }
}
