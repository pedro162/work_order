<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PersonCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $tenant = Tenant::factory()->create();
        $this->actingAs(User::factory()->for($tenant, 'tenant')->create());
    }

    public function testPersonCrudFlowAndResourceShape(): void
    {
        $created = $this->postJson(route('api.v1.people.store'), [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'active' => false,
        ])->assertCreated()->assertJsonPath('data.first_name', 'Jane')
            ->assertJsonPath('data.active', false);

        $id = (int) $created->json('data.id');
        $this->assertGreaterThan(0, $id);

        $this->getJson(route('api.v1.people.show', ['person' => $id]))
            ->assertOk()->assertJsonPath('data.first_name', 'Jane');

        $this->getJson(route('api.v1.people.index', ['limit' => 5]))
            ->assertOk()->assertJsonStructure(['data']);

        $this->patchJson(route('api.v1.people.update', ['person' => $id]), ['first_name' => 'Janet'])
            ->assertOk()->assertJsonPath('data.first_name', 'Janet');

        $this->deleteJson(route('api.v1.people.destroy', ['person' => $id]))->assertNoContent();
        $this->getJson(route('api.v1.people.show', ['person' => $id]))->assertNotFound();
        $this->assertNotNull(Person::withTrashed()->find($id));
    }
}
