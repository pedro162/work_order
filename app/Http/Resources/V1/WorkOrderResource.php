<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class WorkOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'external_code' => $this->stringOrNull(
                $this->resource->getExternalCode()
            ),
            'total_amount' => $this->stringOrNull(
                $this->resource->getTotalValue()
            ),
            'status' => $this->stringOrNull(
                $this->resource->getStatus()
            ),
            'notes' => $this->stringOrNull(
                $this->resource->getObservation()
            ),
            'file_path' => $this->stringOrNull(
                $this->resource->getFilePath()
            ),
            'person_id' => $this->intOrNull(
                $this->resource->getPersonId()
            ),
            'final_amount' => $this->stringOrNull(
                $this->resource->getFinalValue()
            ),
            'discount_amount' => $this->stringOrNull(
                $this->resource->getDiscountValue()
            ),
            'surcharge_percentage' => $this->stringOrNull(
                $this->resource->getIncreasePercent()
            ),
            'surcharge_amount' => $this->stringOrNull(
                $this->resource->getIncreaseValue()
            ),
            'discount_percentage' => $this->stringOrNull(
                $this->resource->getDiscountPercent()
            ),
            'is_billed' => $this->boolOrNull(
                $this->resource->getIsInvoiced()
            ),
            'billed_at' => $this->stringOrNull(
                $this->resource->getBillingAt()
            ),
            'canceled_at' => $this->stringOrNull(
                $this->resource->getCancelAt()
            ),
            'completed_at' => $this->stringOrNull(
                $this->resource->getConcludeAt()
            ),
            'cancel_reason' => $this->stringOrNull(
                $this->resource->getcancelReason()
            ),
            'type' => $this->stringOrNull(
                $this->resource->getType()
            ),
            'is_quote' => $this->boolOrNull(
                $this->resource->getIsBudget()
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
