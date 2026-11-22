<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Tenant;

use App\Application\Handlers\V1\Tenant\GetTenantByIdHandler;
use App\Http\Resources\V1\TenantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowTenantController
{
    public function __invoke(
        int $tenant,
        GetTenantByIdHandler $handler
    ): JsonResponse {
        $entity = $handler->handler($tenant);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(\App\Models\Tenant::class, [$tenant]);
        }

        return (new TenantResource($entity))->response();
    }
}
