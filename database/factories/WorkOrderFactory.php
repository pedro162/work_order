<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrder>
 */
class WorkOrderFactory extends Factory
{
    protected $model = WorkOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAmount = fake()->randomFloat(2, 100, 5000);

        $discountAmount = round(
            $totalAmount * fake()->randomFloat(2, 0, 0.15),
            2
        );

        $finalAmount = round(
            $totalAmount - $discountAmount,
            2
        );

        return [
            'external_code' => 'OS-' . Str::uuid(),
            'total_amount' => $totalAmount,
            'status' => 'PENDING',
            'notes' => fake()->optional()->paragraph(),
            'file_path' => null,
            'person_id' => Person::factory(),
            'user_id' => User::factory(),
            'user_update_id' => null,
            'active' => true,
            'final_amount' => $finalAmount,
            'discount_amount' => $discountAmount,
            'discount_percentage' => $totalAmount > 0
                ? round($discountAmount / $totalAmount * 100, 4)
                : 0,
            'surcharge_percentage' => 0,
            'surcharge_amount' => 0,
            'is_billed' => false,
            'billed_at' => null,
            'canceled_at' => null,
            'completed_at' => null,
            'cancel_reason' => null,
            'type' => 'SERVICE',
            'is_quote' => false,
            'tenant_id' => Tenant::factory(),
        ];
    }

    public function forTenant(int $tenantId): static
    {
        return $this->state(fn() => [
            'tenant_id' => $tenantId,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'COMPLETED',
            'completed_at' => now(),
        ]);
    }

    public function canceled(): static
    {
        return $this->state(fn() => [
            'status' => 'CANCELED',
            'canceled_at' => now(),
            'cancel_reason' => fake()->sentence(),
        ]);
    }

    public function quote(): static
    {
        return $this->state(fn() => [
            'is_quote' => true,
            'status' => 'PENDING',
        ]);
    }

    public function billed(): static
    {
        return $this->state(fn() => [
            'is_billed' => true,
            'billed_at' => now(),
        ]);
    }
}
