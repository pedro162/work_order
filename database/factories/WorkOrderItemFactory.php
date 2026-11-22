<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrderItem>
 */
class WorkOrderItemFactory extends Factory
{
    protected $model = WorkOrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitAmount = fake()->numberBetween(5000, 50000) / 100;

        $totalAmount = round($quantity * $unitAmount, 2);

        $discountPercentage = fake()->numberBetween(0, 2000) / 100;

        $discountAmount = round(
            $totalAmount * $discountPercentage / 100,
            2
        );

        return [
            'external_code' => 'ITEM-' . Str::uuid(),
            'service_name' => fake()->randomElement([
                'Manutenção preventiva',
                'Manutenção corretiva',
                'Instalação de equipamento',
                'Consultoria técnica',
                'Suporte especializado',
            ]),
            'quantity' => $quantity,
            'item_amount' => $unitAmount,
            'gross_item_amount' => $totalAmount,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
            'discount_percentage' => $discountPercentage,
            'surcharge_amount' => 0,
            'surcharge_percentage' => 0,
            'final_amount' => round(
                $totalAmount - $discountAmount,
                2
            ),
            'active' => true,
            'work_order_id' => WorkOrder::factory(),
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

    public function forWorkOrder(WorkOrder $workOrder): static
    {
        return $this
            ->for($workOrder, 'workOrder')
            ->forTenant($workOrder->tenant_id);
    }

    public function withoutDiscount(): static
    {
        return $this->state(fn(array $attributes) => [
            'discount_percentage' => 0,
            'discount_amount' => 0,
            'final_amount' => $attributes['total_amount'],
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn() => [
            'active' => false,
        ]);
    }
}
