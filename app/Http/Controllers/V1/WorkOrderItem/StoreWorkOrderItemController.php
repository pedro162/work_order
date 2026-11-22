<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderItem;

use App\Application\Handlers\V1\WorkOrderItem\CreateWorkOrderItemHandler;
use App\Http\Resources\V1\WorkOrderItemResource;
use App\Application\Commands\V1\WorkOrderItem\CreateWorkOrderItemCommand;
use App\Http\Requests\V1\WorkOrderItem\StoreWorkOrderItemRequest;
use Illuminate\Http\JsonResponse;

final class StoreWorkOrderItemController
{
    public function __invoke(
        StoreWorkOrderItemRequest $request,
        CreateWorkOrderItemHandler $handler
    ): JsonResponse {
        $command = CreateWorkOrderItemCommand::build($request->validated());
        $entity = $handler->handler($command);

        return (new WorkOrderItemResource($entity))
            ->additional([
                'message' => __('api.created', [
                    'resource' => __('api.resources.WorkOrderItem')
                ])
            ])
            ->response()
            ->setStatusCode(201);
    }
}
