<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Tenant;

use App\Application\Handlers\V1\Tenant\UpdateTenantHandler;
use App\Http\Resources\V1\TenantResource;
use App\Application\Commands\V1\Tenant\UpdateTenantCommand;
use App\Http\Requests\V1\Tenant\UpdateTenantRequest;
use Illuminate\Http\JsonResponse;

final class UpdateTenantController
{
    public function __invoke(
        int $tenant,
        UpdateTenantRequest $request,
        UpdateTenantHandler $handler
    ): JsonResponse {
        $command = UpdateTenantCommand::build([
            'id' => $tenant,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new TenantResource($entity))
            ->additional([
                'message' => __(
                    'api.updated',
                    ['resource' => __('api.resources.Tenant')]
                )
            ])
            ->response();
    }
}
