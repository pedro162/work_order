<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateWorkOrderRequest extends FormRequest
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
                'sometimes',
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
