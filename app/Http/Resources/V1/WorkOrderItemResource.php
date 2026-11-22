<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class WorkOrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'quantity' => $this->stringOrNull(
                $this->resource->getQuantity()
            ),
            'external_code' => $this->stringOrNull(
                $this->resource->getExternalCode()
            ),
            'service_name' => $this->stringOrNull(
                $this->resource->getServiceName()
            ),
            'gross_item_amount' => $this->stringOrNull(
                $this->resource->getGrossItemAmount()
            ),
            'total_amount' => $this->stringOrNull(
                $this->resource->getTotalAmount()
            ),
            'item_amount' => $this->stringOrNull(
                $this->resource->getItemAmount()
            ),
            'work_order_id' => $this->intOrNull(
                $this->resource->getWorkOrderId()
            ),
            'final_amount' => $this->stringOrNull(
                $this->resource->getFinalAmount()
            ),
            'discount_amount' => $this->stringOrNull(
                $this->resource->getDiscountAmount()
            ),
            'surcharge_percentage' => $this->stringOrNull(
                $this->resource->getSurchargePercentage()
            ),
            'surcharge_amount' => $this->stringOrNull(
                $this->resource->getSurchargeAmount()
            ),
            'discount_percentage' => $this->stringOrNull(
                $this->resource->getDiscountPercentage()
            ),
            'active' => $this->resource->getActive(),
        ];
    }

    private function stringOrNull(mixed $value): ?string
    {
        return $value === null ? null : (string) $value;
    }

    private function intOrNull(mixed $value): ?int
    {
        return $value === null ? null : (int) (string) $value;
    }

    private function boolOrNull(mixed $value): ?bool
    {
        if ($value === null) {
            return null;
        }

        $result = filter_var(
            (string) $value,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        return $result;
    }
}
