<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Person;

use Illuminate\Foundation\Http\FormRequest;

final class StorePersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:150'
            ],
            'last_name' => [
                'sometimes',
                'string',
                'max:150'
            ],
            'optional_name' => [
                'sometimes',
                'string',
                'max:150'
            ],
            'document' => [
                'sometimes',
                'string',
                'max:30'
            ],
            'extra_document' => [
                'sometimes',
                'string',
                'max:50'
            ],
            'birth_date' => [
                'sometimes',
                'date_format:Y-m-d'
            ],
            'gender' => [
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
}
