<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Person;

use Illuminate\Foundation\Http\FormRequest;

final class ListPersonRequest extends FormRequest
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
            'document' => [
                'sometimes',
                'string',
                'max:30'
            ],
            'type' => [
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

    public function filters(): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip(['document', 'type', 'active'])
        );
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 50);
    }
}
