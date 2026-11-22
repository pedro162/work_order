<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderInstallment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrderInstallment>
 */
class WorkOrderInstallmentFactory extends Factory
{
    protected $model = WorkOrderInstallment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chargeAmount = fake()->randomFloat(2, 50, 1500);

        $surchargeAmount = 0;

        return [
            'work_order_id' => WorkOrder::factory(),
            'external_code' => 'INST-' . Str::uuid(),
            'payment_method' => fake()->randomElement([
                'PIX',
                'CREDIT_CARD',
                'DEBIT_CARD',
                'CASH',
                'BANK_SLIP',
            ]),
            'document_number' => null,
            'charge_amount' => $chargeAmount,
            'surcharge_amount' => $surchargeAmount,
            'final_amount' => round(
                $chargeAmount + $surchargeAmount,
                2
            ),
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

    public function pix(): static
    {
        return $this->state(fn() => [
            'payment_method' => 'PIX',
        ]);
    }

    public function creditCard(): static
    {
        return $this->state(fn() => [
            'payment_method' => 'CREDIT_CARD',
        ]);
    }
}
