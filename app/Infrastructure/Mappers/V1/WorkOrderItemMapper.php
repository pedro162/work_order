<?php

namespace App\Infrastructure\Mappers\V1;

use App\Domain\V1\WorkOrderItem\Entities\WorkOrderItem;
use App\Models\WorkOrderItem as WorkOrderItemModel;

final class WorkOrderItemMapper
{
    public function toDomain(WorkOrderItemModel $model): WorkOrderItem
    {
        return WorkOrderItem::buildEntity($model->getAttributes());
    }

    public function toPersistence(WorkOrderItem $entity): array
    {
        $attributes = [
            'work_order_id' => $entity->getWorkOrderId(),
            'external_code' => $entity->getExternalCode(),
            'service_name' => $entity->getServiceName(),
            'quantity' => $entity->getQuantity(),
            'item_amount' => $entity->getItemAmount(),
            'gross_item_amount' => $entity->getGrossItemAmount(),
            'total_amount' => $entity->getTotalAmount(),
            'final_amount' => $entity->getFinalAmount(),
            'discount_amount' => $entity->getDiscountAmount(),
            'discount_percentage' => $entity->getDiscountPercentage(),
            'surcharge_amount' => $entity->getSurchargeAmount(),
            'surcharge_percentage' => $entity->getSurchargePercentage(),
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
