<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrder;

use App\Application\Handlers\V1\WorkOrder\CreateWorkOrderHandler;
use App\Http\Resources\V1\WorkOrderResource;
use App\Application\Commands\V1\WorkOrder\CreateWorkOrderCommand;
use App\Http\Requests\V1\WorkOrder\StoreWorkOrderRequest;
use Illuminate\Http\JsonResponse;

final class StoreWorkOrderController
{
    public function __invoke(
        StoreWorkOrderRequest $request,
        CreateWorkOrderHandler $handler
    ): JsonResponse {
        $command = CreateWorkOrderCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new WorkOrderResource($entity))
            ->additional([
                'message' => __(
                    'api.created',
                    ['resource' => __('api.resources.WorkOrder')]
                )
            ])
            ->response()
            ->setStatusCode(201);
    }
}
