<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Person;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CrossTenantMutationTest extends TestCase
{
    use RefreshDatabase;

    public function testCrossTenantPatchAndDeleteDoNotMutateForeignRecords(): void
    {
        $a = Tenant::factory()->create();
        $b = Tenant::factory()->create();
        $id = \Illuminate\Support\Facades\DB::table('people')->insertGetId([
            'first_name' => 'Protected', 'tenant_id' => $b->id,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $foreign = Person::withoutGlobalScopes()->findOrFail($id);
        $this->actingAs(User::factory()->for($a, 'tenant')->create());

        $this->patchJson(route('api.v1.people.update', ['person' => $foreign->id]), [
            'first_name' => 'Overwritten',
        ])->assertNotFound();
        $this->deleteJson(route('api.v1.people.destroy', ['person' => $foreign->id]))->assertNotFound();

        $fresh = Person::withoutGlobalScopes()->findOrFail($foreign->id);
        $this->assertSame('Protected', $fresh->first_name);
        $this->assertNull($fresh->deleted_at);
    }
}
