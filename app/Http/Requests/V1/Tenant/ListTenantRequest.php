<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Tenant;

use Illuminate\Foundation\Http\FormRequest;

final class ListTenantRequest extends FormRequest
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
            'active' => [
                'sometimes',
                'boolean'
            ],
            'slug' => [
                'sometimes',
                'string',
                'max:150'
            ],
        ];
    }

    public function filters(): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip(['active', 'slug'])
        );
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 50);
    }
}
