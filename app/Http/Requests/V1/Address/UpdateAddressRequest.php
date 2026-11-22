<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'person_id' => [
                'sometimes',
                'integer',
                'min:1',
                Rule::exists('people', 'id')
                    ->where('tenant_id', $this->user()->tenant_id)
                    ->whereNull('deleted_at')
            ],
            'type' => [
                'sometimes',
                'string',
                'max:30'
            ],
            'zip_code' => [
                'sometimes',
                'string',
                'max:20'
            ],
            'street' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'number' => [
                'sometimes',
                'string',
                'max:20'
            ],
            'complement' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'neighborhood' => [
                'sometimes',
                'string',
                'max:150'
            ],
            'city' => [
                'sometimes',
                'string',
                'max:150'
            ],
            'state' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'country' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'is_primary' => [
                'sometimes',
                'boolean'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
        ];
    }
}
