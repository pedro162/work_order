<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\WorkOrderInstallment;

use Illuminate\Foundation\Http\FormRequest;

final class ListWorkOrderInstallmentRequest extends FormRequest
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
            'work_order_id' => [
                'sometimes',
                'integer',
                'min:1'
            ],
            'payment_method' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
        ];
    }

    public function filters(): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip(['work_order_id', 'payment_method', 'active'])
        );
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 50);
    }
}
