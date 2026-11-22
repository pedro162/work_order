<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderInstallment;

use App\Application\Handlers\V1\WorkOrderInstallment\GetWorkOrderInstallmentByIdHandler;
use App\Http\Resources\V1\WorkOrderInstallmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ShowWorkOrderInstallmentController
{
    public function __invoke(
        int $work_order_installment,
        GetWorkOrderInstallmentByIdHandler $handler
    ): JsonResponse {
        $entity = $handler->handler($work_order_installment);

        if ($entity === null) {
            throw (new ModelNotFoundException())
                ->setModel(
                    \App\Models\WorkOrderInstallment::class,
                    [$work_order_installment]
                );
        }

        return (new WorkOrderInstallmentResource($entity))->response();
    }
}
