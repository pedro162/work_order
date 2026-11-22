<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\WorkOrderInstallment;

use App\Application\Handlers\V1\WorkOrderInstallment\DestroyWorkOrderInstallmentHandler;
use App\Application\Commands\V1\WorkOrderInstallment\DeleteWorkOrderInstallmentCommand;
use Illuminate\Http\JsonResponse;

final class DestroyWorkOrderInstallmentController
{
    public function __invoke(
        int $work_order_installment,
        DestroyWorkOrderInstallmentHandler $handler
    ): JsonResponse {
        $handler->handler(
            DeleteWorkOrderInstallmentCommand::build([
                'id' => $work_order_installment
            ])
        );

        return response()->json(null, 204);
    }
}
