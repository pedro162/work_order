<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Tenant\StoreTenantController;
use App\Http\Controllers\V1\Tenant\IndexTenantController;
use App\Http\Controllers\V1\Tenant\ShowTenantController;
use App\Http\Controllers\V1\Tenant\UpdateTenantController;
use App\Http\Controllers\V1\Tenant\DestroyTenantController;
use App\Http\Controllers\V1\Person\StorePersonController;
use App\Http\Controllers\V1\Person\IndexPersonController;
use App\Http\Controllers\V1\Person\ShowPersonController;
use App\Http\Controllers\V1\Person\UpdatePersonController;
use App\Http\Controllers\V1\Person\DestroyPersonController;
use App\Http\Controllers\V1\Address\StoreAddressController;
use App\Http\Controllers\V1\Address\IndexAddressController;
use App\Http\Controllers\V1\Address\ShowAddressController;
use App\Http\Controllers\V1\Address\UpdateAddressController;
use App\Http\Controllers\V1\Address\DestroyAddressController;
use App\Http\Controllers\V1\WorkOrder\StoreWorkOrderController;
use App\Http\Controllers\V1\WorkOrder\IndexWorkOrderController;
use App\Http\Controllers\V1\WorkOrder\ShowWorkOrderController;
use App\Http\Controllers\V1\WorkOrder\UpdateWorkOrderController;
use App\Http\Controllers\V1\WorkOrder\DestroyWorkOrderController;
use App\Http\Controllers\V1\WorkOrderItem\StoreWorkOrderItemController;
use App\Http\Controllers\V1\WorkOrderItem\IndexWorkOrderItemController;
use App\Http\Controllers\V1\WorkOrderItem\ShowWorkOrderItemController;
use App\Http\Controllers\V1\WorkOrderItem\UpdateWorkOrderItemController;
use App\Http\Controllers\V1\WorkOrderItem\DestroyWorkOrderItemController;
use App\Http\Controllers\V1\WorkOrderInstallment\StoreWorkOrderInstallmentController;
use App\Http\Controllers\V1\WorkOrderInstallment\IndexWorkOrderInstallmentController;
use App\Http\Controllers\V1\WorkOrderInstallment\ShowWorkOrderInstallmentController;
use App\Http\Controllers\V1\WorkOrderInstallment\UpdateWorkOrderInstallmentController;
use App\Http\Controllers\V1\WorkOrderInstallment\DestroyWorkOrderInstallmentController;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    //Route::apiResource();
});

Route::prefix('v1')
    ->name('api.v1.')->middleware('auth:sanctum')->group(function (): void {
        // Tenant operations require an explicitly registered manage-tenants ability.
        Route::middleware('can:manage-tenants')->group(function (): void {
            Route::get(
                'tenants',
                IndexTenantController::class
            )
                ->name('tenants.index');
            Route::post(
                'tenants',
                StoreTenantController::class
            )
                ->name('tenants.store');
            Route::get(
                'tenants/{tenant}',
                ShowTenantController::class
            )
                ->name('tenants.show')->whereNumber('tenant');
            Route::match(
                ['put', 'patch'],
                'tenants/{tenant}',
                UpdateTenantController::class
            )
                ->name('tenants.update')->whereNumber('tenant');
            Route::delete(
                'tenants/{tenant}',
                DestroyTenantController::class
            )
                ->name('tenants.destroy')->whereNumber('tenant');
        });

        Route::get(
            'people',
            IndexPersonController::class
        )
            ->name('people.index');
        Route::post(
            'people',
            StorePersonController::class
        )
            ->name('people.store');
        Route::get(
            'people/{person}',
            ShowPersonController::class
        )
            ->name('people.show')->whereNumber('person');
        Route::match(
            ['put', 'patch'],
            'people/{person}',
            UpdatePersonController::class
        )
            ->name('people.update')->whereNumber('person');
        Route::delete(
            'people/{person}',
            DestroyPersonController::class
        )
            ->name('people.destroy')->whereNumber('person');

        Route::get(
            'addresses',
            IndexAddressController::class
        )
            ->name('addresses.index');
        Route::post(
            'addresses',
            StoreAddressController::class
        )
            ->name('addresses.store');
        Route::get(
            'addresses/{address}',
            ShowAddressController::class
        )
            ->name('addresses.show')->whereNumber('address');
        Route::match(
            ['put', 'patch'],
            'addresses/{address}',
            UpdateAddressController::class
        )
            ->name('addresses.update')->whereNumber('address');
        Route::delete(
            'addresses/{address}',
            DestroyAddressController::class
        )
            ->name('addresses.destroy')->whereNumber('address');

        Route::get(
            'work-orders',
            IndexWorkOrderController::class
        )
            ->name('work_orders.index');
        Route::post(
            'work-orders',
            StoreWorkOrderController::class
        )
            ->name('work_orders.store');
        Route::get(
            'work-orders/{work_order}',
            ShowWorkOrderController::class
        )
            ->name('work_orders.show')->whereNumber('work_order');
        Route::match(
            ['put', 'patch'],
            'work-orders/{work_order}',
            UpdateWorkOrderController::class
        )
            ->name('work_orders.update')->whereNumber('work_order');
        Route::delete(
            'work-orders/{work_order}',
            DestroyWorkOrderController::class
        )
            ->name('work_orders.destroy')->whereNumber('work_order');

        Route::get(
            'work-order-items',
            IndexWorkOrderItemController::class
        )
            ->name('work_order_items.index');
        Route::post(
            'work-order-items',
            StoreWorkOrderItemController::class
        )
            ->name('work_order_items.store');
        Route::get(
            'work-order-items/{work_order_item}',
            ShowWorkOrderItemController::class
        )
            ->name('work_order_items.show')->whereNumber('work_order_item');
        Route::match(
            ['put', 'patch'],
            'work-order-items/{work_order_item}',
            UpdateWorkOrderItemController::class
        )
            ->name('work_order_items.update')->whereNumber('work_order_item');
        Route::delete(
            'work-order-items/{work_order_item}',
            DestroyWorkOrderItemController::class
        )
            ->name('work_order_items.destroy')->whereNumber('work_order_item');

        Route::get(
            'work-order-installments',
            IndexWorkOrderInstallmentController::class
        )
            ->name('work_order_installments.index');
        Route::post(
            'work-order-installments',
            StoreWorkOrderInstallmentController::class
        )
            ->name('work_order_installments.store');
        Route::get(
            'work-order-installments/{work_order_installment}',
            ShowWorkOrderInstallmentController::class
        )
            ->name('work_order_installments.show')->whereNumber('work_order_installment');
        Route::match(
            ['put', 'patch'],
            'work-order-installments/{work_order_installment}',
            UpdateWorkOrderInstallmentController::class
        )
            ->name('work_order_installments.update')->whereNumber('work_order_installment');
        Route::delete(
            'work-order-installments/{work_order_installment}',
            DestroyWorkOrderInstallmentController::class
        )
            ->name('work_order_installments.destroy')->whereNumber('work_order_installment');
    });
