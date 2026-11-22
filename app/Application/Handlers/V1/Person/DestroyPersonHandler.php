<?php

declare(strict_types=1);

namespace App\Application\Handlers\V1\Person;

use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Domain\V1\Person\ValueObjects\PersonId;
use App\Application\Commands\V1\Person\DeletePersonCommand;

final class DestroyPersonHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $repository
    ) {
    }

    public function handler(DeletePersonCommand $command): void
    {
        $this->repository->destroy(new PersonId($command->getId()));
    }
}
