<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ValidationAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $tenant = Tenant::factory()->create();
        $this->actingAs(User::factory()->for($tenant, 'tenant')->create());
    }

    public function testMissingPersonNameIsUnprocessable(): void
    {
        $this->postJson(route('api.v1.people.store'), [])->assertStatus(422)
            ->assertJsonValidationErrors(['first_name']);
    }

    public function testInvalidWorkOrderForeignKeyIsUnprocessable(): void
    {
        $this->postJson(route('api.v1.work_orders.store'), ['person_id' => 999999])
            ->assertStatus(422)->assertJsonValidationErrors(['person_id']);
    }

    public function testInvalidResourceIdReturns404(): void
    {
        $this->getJson(route('api.v1.people.show', ['person' => 'not-an-id']))->assertNotFound();
    }

    public function testTenantAdministrationIsForbiddenWithoutAbility(): void
    {
        $this->getJson(route('api.v1.tenants.index'))->assertForbidden();
        $this->postJson(route('api.v1.tenants.store'), ['name' => 'X', 'slug' => 'x'])->assertForbidden();
    }
}
