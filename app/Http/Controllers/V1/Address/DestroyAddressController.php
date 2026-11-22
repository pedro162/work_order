<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Address;

use App\Application\Handlers\V1\Address\DestroyAddressHandler;
use App\Application\Commands\V1\Address\DeleteAddressCommand;
use Illuminate\Http\JsonResponse;

final class DestroyAddressController
{
    public function __invoke(int $address, DestroyAddressHandler $handler): JsonResponse
    {
        $handler->handler(DeleteAddressCommand::build(['id' => $address]));

        return response()->json(null, 204);
    }
}
