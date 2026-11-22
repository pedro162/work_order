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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('person_id')
                ->constrained('people')
                ->restrictOnDelete();

            $table->string('type', 30)
                ->default('RESIDENTIAL');

            $table->string('zip_code', 20);
            $table->string('street', 255);
            $table->string('number', 20)->nullable();
            $table->string('complement', 255)->nullable();
            $table->string('neighborhood', 150)->nullable();
            $table->string('city', 150);
            $table->string('state', 100);
            $table->string('country', 100)->default('BR');

            $table->boolean('is_primary')->default(false);
            $table->boolean('active')->default(true);

            $table->foreignId('tenant_id')
                ->constrained('tenants')
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

            $table->index(['tenant_id', 'person_id']);
            $table->index(['tenant_id', 'active']);
            $table->index(['person_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
