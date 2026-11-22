<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrder;

use App\Application\Handlers\V1\WorkOrder\GetAllWorkOrderHandler;
use App\Http\Resources\V1\WorkOrderResource;
use App\Http\Requests\V1\WorkOrder\ListWorkOrderRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexWorkOrderController
{
    public function __invoke(
        ListWorkOrderRequest $request,
        GetAllWorkOrderHandler $handler
    ): AnonymousResourceCollection {
        return WorkOrderResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
