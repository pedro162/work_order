<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrderInstallment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreWorkOrderInstallmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'work_order_id' => [
                'required',
                'integer',
                'min:1',
                Rule::exists('work_orders', 'id')
                    ->where('tenant_id', $this->user()->tenant_id)
                    ->whereNull('deleted_at')
            ],
            'external_code' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'payment_method' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'document_number' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'charge_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'surcharge_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'final_amount' => [
                'sometimes',
                'string',
                'regex:/^\d{1,13}(?:\.\d{1,2})?$/'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
        ];
    }
}
