<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;

final class ListAddressRequest extends FormRequest
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
            'person_id' => [
                'sometimes',
                'integer',
                'min:1'
            ],
            'active' => [
                'sometimes',
                'boolean'
            ],
            'type' => [
                'sometimes',
                'string',
                'max:30'
            ],
        ];
    }

    public function filters(): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip(['person_id', 'active', 'type'])
        );
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 50);
    }
}
