<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderItem;

use App\Application\Handlers\V1\WorkOrderItem\DestroyWorkOrderItemHandler;
use App\Application\Commands\V1\WorkOrderItem\DeleteWorkOrderItemCommand;
use Illuminate\Http\JsonResponse;

final class DestroyWorkOrderItemController
{
    public function __invoke(
        int $work_order_item,
        DestroyWorkOrderItemHandler $handler
    ): JsonResponse {
        $handler->handler(
            DeleteWorkOrderItemCommand::build([
                'id' => $work_order_item
            ])
        );

        return response()->json(null, 204);
    }
}
