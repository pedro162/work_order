<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Input is a domain Entity, not an Eloquent model.
 */
final class TenantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->stringOrNull(
                $this->resource->getId()
            ),
            'name' => $this->stringOrNull(
                $this->resource->getName()
            ),
            'trade_name' => $this->stringOrNull(
                $this->resource->getTradeName()
            ),
            'slug' => $this->stringOrNull(
                $this->resource->getSlug()
            ),
            'document' => $this->stringOrNull(
                $this->resource->getDocument()
            ),
            'email' => $this->stringOrNull(
                $this->resource->getEmail()
            ),
            'phone' => $this->stringOrNull(
                $this->resource->getPhone()
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
