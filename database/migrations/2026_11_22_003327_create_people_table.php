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
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->string('external_code', 255)->nullable();
            $table->string('first_name', 150);
            $table->string('last_name', 150)->nullable();
            $table->string('optional_name', 150)->nullable();

            $table->string('document', 30)->nullable();
            $table->string('extra_document', 50)->nullable();

            $table->date('birth_date')->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('type', 30)->nullable();

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

            $table->index(['tenant_id', 'active']);
            $table->index(['tenant_id', 'document']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
