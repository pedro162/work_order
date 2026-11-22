<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_code' => 'PERS-' . Str::uuid(),
            'first_name' => fake('pt_BR')->firstName(),
            'last_name' => fake('pt_BR')->lastName(),
            'optional_name' => null,
            'document' => fake('pt_BR')->cpf(false),
            'extra_document' => null,
            'birth_date' => fake()->dateTimeBetween(
                '-75 years',
                '-18 years'
            )->format('Y-m-d'),
            'gender' => fake()->randomElement([
                'MALE',
                'FEMALE',
                'OTHER',
            ]),
            'type' => 'CUSTOMER',
            'user_id' => User::factory(),
            'user_update_id' => null,
            'active' => true,
            'tenant_id' => Tenant::factory(),
        ];
    }

    public function forTenant(int $tenantId): static
    {
        return $this->state(fn() => [
            'tenant_id' => $tenantId,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn() => [
            'active' => false,
        ]);
    }
}
