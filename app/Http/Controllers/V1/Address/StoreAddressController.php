<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Address;

use App\Application\Handlers\V1\Address\CreateAddressHandler;
use App\Http\Resources\V1\AddressResource;
use App\Application\Commands\V1\Address\CreateAddressCommand;
use App\Http\Requests\V1\Address\StoreAddressRequest;
use Illuminate\Http\JsonResponse;

final class StoreAddressController
{
    public function __invoke(StoreAddressRequest $request, CreateAddressHandler $handler): JsonResponse
    {
        $command = CreateAddressCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new AddressResource($entity))
            ->additional([
                'message' => __(
                    'api.created',
                    ['resource' => __('api.resources.Address')]
                )
            ])
            ->response()
            ->setStatusCode(201);
    }
}
