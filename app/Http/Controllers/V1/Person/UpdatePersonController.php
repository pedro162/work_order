<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Person;

use App\Application\Handlers\V1\Person\UpdatePersonHandler;
use App\Http\Resources\V1\PersonResource;
use App\Application\Commands\V1\Person\UpdatePersonCommand;
use App\Http\Requests\V1\Person\UpdatePersonRequest;
use Illuminate\Http\JsonResponse;

final class UpdatePersonController
{
    public function __invoke(int $person, UpdatePersonRequest $request, UpdatePersonHandler $handler): JsonResponse
    {
        $command = UpdatePersonCommand::build([
            'id' => $person,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new PersonResource($entity))
            ->additional([
                'message' => __(
                    'api.updated',
                    ['resource' => __('api.resources.Person')]
                )])
            ->response();
    }
}
