<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    private function signIn(Tenant $tenant): void
    {
        $user = User::factory()->for($tenant, 'tenant')->create();
        $this->actingAs($user);
    }

    public function testAUserCannotReadAnotherTenantsPerson(): void
    {
        $a = Tenant::factory()->create();
        $b = Tenant::factory()->create();
        $this->signIn($a);

        // Factories have explicit tenant IDs; fixture setup should bypass only the scope,
        // never spoof the current authenticated tenant during an application operation.
        $id = \Illuminate\Support\Facades\DB::table('people')->insertGetId([
            'first_name' => 'Other Tenant', 'tenant_id' => $b->id,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $foreign = Person::withoutGlobalScopes()->findOrFail($id);
        $this->getJson(route('api.v1.people.show', ['person' => $foreign->id]))->assertNotFound();
    }

    public function testWorkOrderCannotReferenceAPersonFromAnotherTenant(): void
    {
        $a = Tenant::factory()->create();
        $b = Tenant::factory()->create();
        $this->signIn($a);
        $id = \Illuminate\Support\Facades\DB::table('people')->insertGetId([
            'first_name' => 'Foreign', 'tenant_id' => $b->id,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $foreign = Person::withoutGlobalScopes()->findOrFail($id);
        $this->postJson(route('api.v1.work_orders.store'), [
            'person_id' => $foreign->id,
        ])->assertStatus(422)->assertJsonValidationErrors(['person_id']);
    }

    public function testUserCannotOverrideTenantOnPersonCreate(): void
    {
        $a = Tenant::factory()->create();
        $b = Tenant::factory()->create();
        $this->signIn($a);
        $this->postJson(route('api.v1.people.store'), [
            'first_name' => 'Jane', 'tenant_id' => $b->id,
        ])->assertStatus(201);

        $record = Person::withoutGlobalScopes()->latest('id')->firstOrFail();
        $this->assertSame($a->id, (int) $record->tenant_id);
    }

    public function testInvalidForeignKeyIsRejected(): void
    {
        $tenant = Tenant::factory()->create();
        $this->signIn($tenant);
        $this->postJson(route('api.v1.addresses.store'), [
            'person_id' => 999999,
            'zip_code' => '65000000',
            'street' => 'Main',
            'city' => 'Sao Luis',
            'state' => 'MA',
        ])->assertStatus(422)->assertJsonValidationErrors(['person_id']);
    }
}
