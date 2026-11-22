<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'external_code' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'total_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'status' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'notes' => [
                'sometimes',
                'string'
            ],
            'file_path' => [
                'sometimes',
                'string',
                'max:2048'
            ],
            'person_id' => [
                'required',
                'integer',
                'min:1',
                Rule::exists('people', 'id')
                    ->where('tenant_id', $this->user()->tenant_id)
                    ->whereNull('deleted_at')
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
            'final_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'discount_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'surcharge_percentage' => [
                'sometimes',
                'string',
                'regex:/^\d{1,4}(?:\.\d{1,4})?$/'
            ],
            'surcharge_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'discount_percentage' => [
                'sometimes',
                'string',
                'regex:/^\d{1,4}(?:\.\d{1,4})?$/'
            ],
            'type' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'is_quote' => [
                'sometimes',
                'boolean'
            ],
        ];
    }
}
