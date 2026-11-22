<?php

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\WorkOrderInstallment\Entities\WorkOrderInstallment;
use App\Models\WorkOrderInstallment as WorkOrderInstallmentModel;

final class WorkOrderInstallmentMapper
{
    public function toDomain(WorkOrderInstallmentModel $model): WorkOrderInstallment
    {
        return WorkOrderInstallment::buildEntity($model->getAttributes());
    }

    public function toPersistence(WorkOrderInstallment $entity): array
    {
        $attributes = [
            'work_order_id' => $entity->getWorkOrderId(),
            'external_code' => $entity->getExternalCode(),
            'payment_method' => $entity->getPaymentMethod(),
            'document_number' => $entity->getDocumentNumber(),
            'charge_amount' => $entity->getChargeAmount(),
            'surcharge_amount' => $entity->getSurchargeAmount(),
            'final_amount' => $entity->getFinalAmount(),
            'active' => $entity->getActive(),
        ];

        $data = [];

        foreach ($attributes as $key => $value) {
            if ($value !== null) {
                $data[$key] = (string) $value;
            }
        }

        if ($entity->getActive() !== null) {
            $data['active'] = $entity->getActive();
        }

        return $data;
    }
}
