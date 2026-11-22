<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrderItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateWorkOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'sometimes',
                'string',
                'regex:/^\d{1,9}(?:\.\d{1,3})?$/'
            ],
            'external_code' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'service_name' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'item_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
            'work_order_id' => [
                'sometimes',
                'integer',
                'min:1',
                Rule::exists('work_orders', 'id')
                    ->where('tenant_id', $this->user()->tenant_id)
                    ->whereNull('deleted_at')
            ],
        ];
    }
}
