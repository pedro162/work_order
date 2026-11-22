<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'trade_name' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'slug' => [
                'required',
                'string',
                'max:150',
                Rule::unique('tenants', 'slug')
            ],
            'document' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('tenants', 'document')
            ],
            'email' => [
                'sometimes',
                'email',
                'max:255'
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:30'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
        ];
    }
}
