<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Person;

use App\Application\Handlers\V1\Person\CreatePersonHandler;
use App\Http\Resources\V1\PersonResource;
use App\Application\Commands\V1\Person\CreatePersonCommand;
use App\Http\Requests\V1\Person\StorePersonRequest;
use Illuminate\Http\JsonResponse;

final class StorePersonController
{
    public function __invoke(StorePersonRequest $request, CreatePersonHandler $handler): JsonResponse
    {
        $command = CreatePersonCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new PersonResource($entity))
            ->additional(
                ['message' => __(
                    'api.created',
                    ['resource' => __('api.resources.Person')]
                )]
            )
            ->response()
            ->setStatusCode(201);
    }
}
