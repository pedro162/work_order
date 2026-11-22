<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrder;

use App\Application\Handlers\V1\WorkOrder\GetWorkOrderByIdHandler;
use App\Http\Resources\V1\WorkOrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowWorkOrderController
{
    public function __invoke(
        int $work_order,
        GetWorkOrderByIdHandler $handler
    ): JsonResponse {
        $entity = $handler->handler($work_order);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(\App\Models\WorkOrder::class, [$work_order]);
        }

        return (new WorkOrderResource($entity))->response();
    }
}
