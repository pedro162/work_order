<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Person;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TenantScopeFailsClosedTest extends TestCase
{
    use RefreshDatabase;

    public function testQueriesWithoutTenantContextAreRejected(): void
    {
        Tenant::factory()->create();
        // This is a security regression test. It SHOULD FAIL with the original
        // TenantScope using if (auth()->check()) { ... } and no else branch.
        try {
            Person::query()->count();
            $this->fail('Unscoped unauthenticated queries expose tenant data.');
        } catch (\RuntimeException $exception) {
            $this->assertNotSame('', $exception->getMessage());
        }
    }
}
