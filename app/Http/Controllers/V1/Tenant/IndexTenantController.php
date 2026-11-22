<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Tenant;

use App\Application\Handlers\V1\Tenant\GetAllTenantHandler;
use App\Http\Resources\V1\TenantResource;
use App\Http\Requests\V1\Tenant\ListTenantRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexTenantController
{
    public function __invoke(
        ListTenantRequest $request,
        GetAllTenantHandler $handler
    ): AnonymousResourceCollection {
        return TenantResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
