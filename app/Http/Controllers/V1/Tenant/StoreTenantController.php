<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Tenant;

use App\Application\Handlers\V1\Tenant\CreateTenantHandler;
use App\Http\Resources\V1\TenantResource;
use App\Application\Commands\V1\Tenant\CreateTenantCommand;
use App\Http\Requests\V1\Tenant\StoreTenantRequest;
use Illuminate\Http\JsonResponse;

final class StoreTenantController
{
    public function __invoke(
        StoreTenantRequest $request,
        CreateTenantHandler $handler
    ): JsonResponse {
        $command = CreateTenantCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new TenantResource($entity))
            ->additional([
                'message' => __(
                    'api.created',
                    ['resource' => __('api.resources.Tenant')]
                )
            ])
            ->response()
            ->setStatusCode(201);
    }
}
