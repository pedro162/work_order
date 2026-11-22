<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderInstallment;

use App\Application\Handlers\V1\WorkOrderInstallment\CreateWorkOrderInstallmentHandler;
use App\Http\Resources\V1\WorkOrderInstallmentResource;
use App\Application\Commands\V1\WorkOrderInstallment\CreateWorkOrderInstallmentCommand;
use App\Http\Requests\V1\WorkOrderInstallment\StoreWorkOrderInstallmentRequest;
use Illuminate\Http\JsonResponse;

final class StoreWorkOrderInstallmentController
{
    public function __invoke(
        StoreWorkOrderInstallmentRequest $request,
        CreateWorkOrderInstallmentHandler $handler
    ): JsonResponse {
        $command = CreateWorkOrderInstallmentCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new WorkOrderInstallmentResource($entity))
            ->additional([
                'message' => __('api.created', [
                    'resource' => __('api.resources.WorkOrderInstallment')
                ])
            ])
            ->response()
            ->setStatusCode(201);
    }
}
