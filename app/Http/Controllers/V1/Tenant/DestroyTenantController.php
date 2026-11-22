<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Tenant;

use App\Application\Handlers\V1\Tenant\DestroyTenantHandler;
use App\Application\Commands\V1\Tenant\DeleteTenantCommand;
use Illuminate\Http\JsonResponse;

final class DestroyTenantController
{
    public function __invoke(int $tenant, DestroyTenantHandler $handler): JsonResponse
    {
        $handler->handler(DeleteTenantCommand::build(['id' => $tenant]));

        return response()->json(null, 204);
    }
}
