<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => null,
            'type' => fake()->randomElement([
                'RESIDENTIAL',
                'COMMERCIAL',
                'BILLING',
            ]),
            'zip_code' => fake('pt_BR')->postcode(),
            'street' => fake('pt_BR')->streetName(),
            'number' => (string) fake()->numberBetween(1, 9999),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake('pt_BR')->city(),
            'city' => fake('pt_BR')->city(),
            'state' => fake('pt_BR')->stateAbbr(),
            'country' => 'BR',
            'is_primary' => false,
            'active' => true,
            'user_id' => User::factory(),
            'user_update_id' => null,
            'tenant_id' => Tenant::factory(),
        ];
    }

    public function forTenant(int $tenantId): static
    {
        return $this->state(fn() => [
            'tenant_id' => $tenantId,
        ]);
    }

    public function primary(): static
    {
        return $this->state(fn() => [
            'is_primary' => true,
        ]);
    }

    public function residential(): static
    {
        return $this->state(fn() => [
            'type' => 'RESIDENTIAL',
        ]);
    }
}
