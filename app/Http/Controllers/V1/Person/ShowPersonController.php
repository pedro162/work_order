<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Person;

use App\Application\Handlers\V1\Person\GetPersonByIdHandler;
use App\Http\Resources\V1\PersonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowPersonController
{
    public function __invoke(int $person, GetPersonByIdHandler $handler): JsonResponse
    {
        $entity = $handler->handler($person);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(\App\Models\Person::class, [$person]);
        }

        return (new PersonResource($entity))->response();
    }
}
