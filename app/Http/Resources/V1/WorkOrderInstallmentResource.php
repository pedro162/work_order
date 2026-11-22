<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class WorkOrderInstallmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'work_order_id' => $this->intOrNull(
                $this->resource->getWorkOrderId()
            ),
            'external_code' => $this->stringOrNull(
                $this->resource->getExternalCode()
            ),
            'payment_method' => $this->stringOrNull(
                $this->resource->getPaymentMethod()
            ),
            'document_number' => $this->stringOrNull(
                $this->resource->getDocumentNumber()
            ),
            'charge_amount' => $this->stringOrNull(
                $this->resource->getChargeAmount()
            ),
            'surcharge_amount' => $this->stringOrNull(
                $this->resource->getSurchargeAmount()
            ),
            'final_amount' => $this->stringOrNull(
                $this->resource->getFinalAmount()
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
