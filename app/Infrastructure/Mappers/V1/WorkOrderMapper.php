<?php

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\WorkOrder\Entities\WorkOrder;
use App\Models\WorkOrder as WorkOrderModel;
use InvalidArgumentException;

final class WorkOrderMapper
{
    public function toDomain(WorkOrderModel $model): WorkOrder
    {
        return WorkOrder::buildEntity(
            $model->getAttributes()
        );
    }

    public function toPersistence(WorkOrder $entity): array
    {
        $data = [];

        $fields = [
            'external_code' => $entity->getExternalCode(),
            'person_id' => $entity->getPersonId(),
            'total_amount' => $entity->getTotalValue(),
            'final_amount' => $entity->getFinalValue(),
            'discount_amount' => $entity->getDiscountValue(),
            'surcharge_percentage' => $entity->getIncreasePercent(),
            'surcharge_amount' => $entity->getIncreaseValue(),
            'discount_percentage' => $entity->getDiscountPercent(),
            'status' => $entity->getStatus(),
            'type' => $entity->getType(),
            'notes' => $entity->getObservation(),
            'file_path' => $entity->getFilePath(),
            'cancel_reason' => $entity->getcancelReason(),
            'billed_at' => $entity->getBillingAt(),
            'canceled_at' => $entity->getCancelAt(),
            'completed_at' => $entity->getConcludeAt(),
            'user_id' => $entity->getUserId(),
            'user_update_id' => $entity->getUserUpdateId(),
        ];

        foreach ($fields as $key => $value) {
            if ($value !== null) {
                $data[$key] = (string) $value;
            }
        }

        if ($entity->getActive() !== null) {
            $data['active'] = $entity->getActive();
        }

        foreach (
            [
                'is_billed' => $entity->getIsInvoiced(),
                'is_quote' => $entity->getIsBudget(),
            ] as $key => $value
        ) {
            if ($value !== null) {
                $data[$key] = filter_var(
                    (string) $value,
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                ) ?? throw new InvalidArgumentException(
                    "Valor booleano inválido: {$key}"
                );
            }
        }

        return $data;
    }
}
