<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Address;

use App\Application\Handlers\V1\Address\GetAllAddressHandler;
use App\Http\Resources\V1\AddressResource;
use App\Http\Requests\V1\Address\ListAddressRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexAddressController
{
    public function __invoke(ListAddressRequest $request, GetAllAddressHandler $handler): AnonymousResourceCollection
    {
        return AddressResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
