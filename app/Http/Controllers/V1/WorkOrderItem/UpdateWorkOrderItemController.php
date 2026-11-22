<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderItem;

use App\Application\Handlers\V1\WorkOrderItem\UpdateWorkOrderItemHandler;
use App\Http\Resources\V1\WorkOrderItemResource;
use App\Application\Commands\V1\WorkOrderItem\UpdateWorkOrderItemCommand;
use App\Http\Requests\V1\WorkOrderItem\UpdateWorkOrderItemRequest;
use Illuminate\Http\JsonResponse;

final class UpdateWorkOrderItemController
{
    public function __invoke(
        int $work_order_item,
        UpdateWorkOrderItemRequest $request,
        UpdateWorkOrderItemHandler $handler
    ): JsonResponse {
        $command = UpdateWorkOrderItemCommand::build([
            'id' => $work_order_item,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new WorkOrderItemResource($entity))
            ->additional([
                'message' => __('api.updated', [
                    'resource' => __('api.resources.WorkOrderItem')
                ])
            ])
            ->response();
    }
}
