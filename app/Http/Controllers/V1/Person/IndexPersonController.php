<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Person;

use App\Application\Handlers\V1\Person\GetAllPersonHandler;
use App\Http\Resources\V1\PersonResource;
use App\Http\Requests\V1\Person\ListPersonRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexPersonController
{
    public function __invoke(ListPersonRequest $request, GetAllPersonHandler $handler): AnonymousResourceCollection
    {
        return PersonResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
