<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class PersonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'first_name' => $this->stringOrNull(
                $this->resource->getFirstName()
            ),
            'last_name' => $this->stringOrNull(
                $this->resource->getLastName()
            ),
            'optional_name' => $this->stringOrNull(
                $this->resource->getOptionalName()
            ),
            'document' => $this->stringOrNull(
                $this->resource->getDocument()
            ),
            'extra_document' => $this->stringOrNull(
                $this->resource->getExtraDocument()
            ),
            'birth_date' => $this->stringOrNull(
                $this->resource->getBirthDate()
            ),
            'gender' => $this->stringOrNull(
                $this->resource->getGender()
            ),
            'type' => $this->stringOrNull(
                $this->resource->getType()
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
