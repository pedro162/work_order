<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrder;

use App\Application\Handlers\V1\WorkOrder\UpdateWorkOrderHandler;
use App\Http\Resources\V1\WorkOrderResource;
use App\Application\Commands\V1\WorkOrder\UpdateWorkOrderCommand;
use App\Http\Requests\V1\WorkOrder\UpdateWorkOrderRequest;
use Illuminate\Http\JsonResponse;

final class UpdateWorkOrderController
{
    public function __invoke(
        int $work_order,
        UpdateWorkOrderRequest $request,
        UpdateWorkOrderHandler $handler
    ): JsonResponse {
        $command = UpdateWorkOrderCommand::build([
            'id' => $work_order,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new WorkOrderResource($entity))
            ->additional([
                'message' => __(
                    'api.updated',
                    ['resource' => __('api.resources.WorkOrder')]
                )
            ])
            ->response();
    }
}
