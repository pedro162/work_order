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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            $table->string('external_code', 100)->nullable();
            $table->string('status', 50)->default('PENDING');
            $table->string('type', 50)->nullable();

            $table->text('notes')->nullable();
            $table->string('file_path', 2048)->nullable();

            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);

            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('discount_percentage', 8, 4)->default(0);

            $table->decimal('surcharge_amount', 15, 2)->default(0);
            $table->decimal('surcharge_percentage', 8, 4)->default(0);

            $table->boolean('active')->default(true);
            $table->boolean('is_billed')->default(false);
            $table->boolean('is_quote')->default(false);

            $table->timestamp('billed_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('cancel_reason')->nullable();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->restrictOnDelete();

            $table->foreignId('person_id')
                ->constrained('people')
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

            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'active']);
            $table->index(['tenant_id', 'external_code']);
            $table->index(['tenant_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
