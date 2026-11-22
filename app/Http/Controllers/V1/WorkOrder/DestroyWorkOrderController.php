<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrder;

use App\Application\Handlers\V1\WorkOrder\DestroyWorkOrderHandler;
use App\Application\Commands\V1\WorkOrder\DeleteWorkOrderCommand;
use Illuminate\Http\JsonResponse;

final class DestroyWorkOrderController
{
    public function __invoke(
        int $work_order,
        DestroyWorkOrderHandler $handler
    ): JsonResponse {
        $handler->handler(DeleteWorkOrderCommand::build(['id' => $work_order]));

        return response()->json(null, 204);
    }
}
