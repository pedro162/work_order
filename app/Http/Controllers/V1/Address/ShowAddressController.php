<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Address;

use App\Application\Handlers\V1\Address\GetAddressByIdHandler;
use App\Http\Resources\V1\AddressResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowAddressController
{
    public function __invoke(int $address, GetAddressByIdHandler $handler): JsonResponse
    {
        $entity = $handler->handler($address);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(\App\Models\Address::class, [$address]);
        }

        return (new AddressResource($entity))->response();
    }
}
