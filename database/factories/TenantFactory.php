<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('pt_BR')->company();

        return [
            'name' => $name,
            'trade_name' => $name,
            'slug' => Str::slug($name) . '-' . Str::lower(Str::random(6)),
            'document' => fake('pt_BR')->unique()->cnpj(false),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake('pt_BR')->phoneNumber(),
            'active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn() => [
            'active' => false,
        ]);
    }
}
