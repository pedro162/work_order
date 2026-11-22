<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderInstallment;

use App\Application\Handlers\V1\WorkOrderInstallment\GetAllWorkOrderInstallmentHandler;
use App\Http\Resources\V1\WorkOrderInstallmentResource;
use App\Http\Requests\V1\WorkOrderInstallment\ListWorkOrderInstallmentRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexWorkOrderInstallmentController
{
    public function __invoke(
        ListWorkOrderInstallmentRequest $request,
        GetAllWorkOrderInstallmentHandler $handler
    ): AnonymousResourceCollection {
        return WorkOrderInstallmentResource::collection(
            $handler->handler($request->filters(), $request->limit())
        );
    }
}
