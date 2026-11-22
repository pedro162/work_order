<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrder;

use Illuminate\Foundation\Http\FormRequest;

final class ListWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100'
            ],
            'status' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'person_id' => [
                'sometimes',
                'integer',
                'min:1'
            ],
            'type' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
            'is_quote' => [
                'sometimes',
                'boolean'
            ],
            'is_billed' => [
                'sometimes',
                'boolean'
            ],
        ];
    }

    public function filters(): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip([
                'status',
                'person_id',
                'type',
                'active',
                'is_quote',
                'is_billed'
            ])
        );
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 50);
    }
}
