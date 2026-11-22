<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class RouteContractTest extends TestCase
{
    public static function resources(): array
    {
        return [
            'tenants' => ['tenants', 'tenant'],
            'people' => ['people', 'person'],
            'addresses' => ['addresses', 'address'],
            'workOrders' => ['work_orders', 'work_order'],
            'workOrderItems' => ['work_order_items', 'work_order_item'],
            'workOrderInstallments' => ['work_order_installments', 'work_order_installment'],
        ];
    }

    #[DataProvider('resources')]
    public function testAllFiveRestRoutesExist(string $resource, string $parameter): void
    {
        $methods = [
            'index' => 'GET',
            'store' => 'POST',
            'show' => 'GET',
            'update' => 'PATCH',
            'destroy' => 'DELETE',
        ];

        foreach ($methods as $action => $method) {
            $routeName = "api.v1.{$resource}.{$action}";
            $this->assertTrue(Route::has($routeName), "Missing route: {$routeName}");
            $registeredRoute = Route::getRoutes()->getByName($routeName);
            $this->assertNotNull($registeredRoute);
            $this->assertContains($method, $registeredRoute->methods());

            $parameters = in_array($action, ['index', 'store'], true)
                ? []
                : [$parameter => 1];

            $this->assertNotSame('', route($routeName, $parameters, false));
        }
    }

    #[DataProvider('resources')]
    public function testEveryEndpointRequiresAuthentication(string $resource, string $parameter): void
    {
        $base = "api.v1.{$resource}.";
        $id = [$parameter => 1];

        $this->getJson(route($base . 'index'))->assertUnauthorized();
        $this->postJson(route($base . 'store'), [])->assertUnauthorized();
        $this->getJson(route($base . 'show', $id))->assertUnauthorized();
        $this->patchJson(route($base . 'update', $id), [])->assertUnauthorized();
        $this->deleteJson(route($base . 'destroy', $id))->assertUnauthorized();
    }
}
