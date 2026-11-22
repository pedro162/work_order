<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Address;

use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Domain\V1\Address\ValueObjects\AddressId;
use App\Application\Commands\V1\Address\DeleteAddressCommand;

final class DestroyAddressHandler
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository
    ) {
    }

    public function handler(DeleteAddressCommand $command): void
    {
        $this->repository->destroy(new AddressId($command->getId()));
    }
}
