<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_outbox', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->uuid('event_id')->unique();
            $table->string('routing_key');
            $table->text('body');
            $table->unsignedInteger('attempts')->default(0);
            $table->text('last_error')->nullable();
            $table->timestampTz('next_attempt_at')->nullable();
            $table->timestampTz('locked_until')->nullable();
            $table->timestampTz('published_at')->nullable();
            $table->timestampsTz();
            $table->index(['published_at', 'next_attempt_at']);
        });
        Schema::create('integration_inbox', function (Blueprint $table): void {
            $table->uuid('event_id')->primary();
            $table->string('producer');
            $table->string('tenant_id');
            $table->string('event_type');
            $table->timestampTz('created_at');
        });
        Schema::create('integration_tenant_mappings', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('producer');
            $table->string('external_tenant_id');
            $table->foreignId('local_tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->unique(['producer', 'external_tenant_id']);
        });
        Schema::create('integration_remote_customers', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('producer');
            $table->string('external_customer_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->boolean('active')->default(true);
            $table->timestampsTz();
            $table->unique(['tenant_id', 'producer', 'external_customer_id'], 'remote_customers_tenant_source_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_remote_customers');
        Schema::dropIfExists('integration_tenant_mappings');
        Schema::dropIfExists('integration_inbox');
        Schema::dropIfExists('integration_outbox');
    }
};
