<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderInstallment;

use App\Application\Handlers\V1\WorkOrderInstallment\UpdateWorkOrderInstallmentHandler;
use App\Http\Resources\V1\WorkOrderInstallmentResource;
use App\Application\Commands\V1\WorkOrderInstallment\UpdateWorkOrderInstallmentCommand;
use App\Http\Requests\V1\WorkOrderInstallment\UpdateWorkOrderInstallmentRequest;
use Illuminate\Http\JsonResponse;

final class UpdateWorkOrderInstallmentController
{
    public function __invoke(
        int $work_order_installment,
        UpdateWorkOrderInstallmentRequest $request,
        UpdateWorkOrderInstallmentHandler $handler
    ): JsonResponse {
        $command = UpdateWorkOrderInstallmentCommand::build([
            'id' => $work_order_installment,
            ...$request->validated(),
        ]);

        $entity = $handler->handler($command);

        return (new WorkOrderInstallmentResource($entity))
            ->additional([
                'message' => __('api.updated', [
                    'resource' => __('api.resources.WorkOrderInstallment')
                ])
            ])
            ->response();
    }
}
