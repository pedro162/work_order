<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderItem;

use App\Application\Handlers\V1\WorkOrderItem\GetAllWorkOrderItemHandler;
use App\Http\Resources\V1\WorkOrderItemResource;
use App\Http\Requests\V1\WorkOrderItem\ListWorkOrderItemRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexWorkOrderItemController
{
    public function __invoke(
        ListWorkOrderItemRequest $request,
        GetAllWorkOrderItemHandler $handler
    ): AnonymousResourceCollection {
        return WorkOrderItemResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
