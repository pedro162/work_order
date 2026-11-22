<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderItem;

use App\Application\Handlers\V1\WorkOrderItem\GetWorkOrderItemByIdHandler;
use App\Http\Resources\V1\WorkOrderItemResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowWorkOrderItemController
{
    public function __invoke(
        int $work_order_item,
        GetWorkOrderItemByIdHandler $handler
    ): JsonResponse {
        $entity = $handler->handler($work_order_item);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(
                    \App\Models\WorkOrderItem::class,
                    [$work_order_item]
                );
        }

        return (new WorkOrderItemResource($entity))->response();
    }
}
