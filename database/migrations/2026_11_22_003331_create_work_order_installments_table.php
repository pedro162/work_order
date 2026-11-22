<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_order_installments', function (Blueprint $table) {
            $table->id();

            $table->string('external_code', 255)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('document_number', 100)->nullable();

            $table->decimal('charge_amount', 15, 2)->default(0);
            $table->decimal('surcharge_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);

            $table->boolean('active')->default(true);

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('work_order_id')
                ->constrained('work_orders')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('user_update_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'active']);
            $table->index(['tenant_id', 'external_code']);
            $table->index(['tenant_id', 'payment_method']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_installments');
    }
};
