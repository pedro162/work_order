<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Address;

use App\Application\Handlers\V1\Address\UpdateAddressHandler;
use App\Http\Resources\V1\AddressResource;
use App\Application\Commands\V1\Address\UpdateAddressCommand;
use App\Http\Requests\V1\Address\UpdateAddressRequest;
use Illuminate\Http\JsonResponse;

final class UpdateAddressController
{
    public function __invoke(int $address, UpdateAddressRequest $request, UpdateAddressHandler $handler): JsonResponse
    {
        $command = UpdateAddressCommand::build([
            'id' => $address,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new AddressResource($entity))
            ->additional([
                'message' => __(
                    'api.updated',
                    ['resource' => __('api.resources.Address')]
                )
            ])
            ->response();
    }
}
