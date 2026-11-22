<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'person_id' => $this->intOrNull(
                $this->resource->getPersonId()
            ),
            'type' => $this->stringOrNull(
                $this->resource->getType()
            ),
            'zip_code' => $this->stringOrNull(
                $this->resource->getZipCode()
            ),
            'street' => $this->stringOrNull(
                $this->resource->getStreet()
            ),
            'number' => $this->stringOrNull(
                $this->resource->getNumber()
            ),
            'complement' => $this->stringOrNull(
                $this->resource->getComplement()
            ),
            'neighborhood' => $this->stringOrNull(
                $this->resource->getNeighborhood()
            ),
            'city' => $this->stringOrNull(
                $this->resource->getCity()
            ),
            'state' => $this->stringOrNull(
                $this->resource->getState()
            ),
            'country' => $this->stringOrNull(
                $this->resource->getCountry()
            ),
            'is_primary' => $this->boolOrNull(
                $this->resource->getIsPrimary()
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
