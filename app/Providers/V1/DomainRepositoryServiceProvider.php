<?php

namespace App\Providers\V1;

use Illuminate\Support\ServiceProvider;
use App\Domain\V1\Tenant\Repositories\TenantRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\Tenant\TenantEloquentRepository;
use App\Domain\V1\Person\Repositories\PersonRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\Person\PersonEloquentRepository;
use App\Domain\V1\Address\Repositories\AddressRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\Address\AddressEloquentRepository;
use App\Domain\V1\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\WorkOrder\WorkOrderEloquentRepository;
use App\Domain\V1\WorkOrderItem\Repositories\WorkOrderItemRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\WorkOrderItem\WorkOrderItemEloquentRepository;
use App\Domain\V1\WorkOrderInstallment\Repositories\WorkOrderInstallmentRepositoryInterface;
use App\Infrastructure\Repositories\Eloquent\WorkOrderInstallment\WorkOrderInstallmentEloquentRepository;

final class DomainRepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TenantRepositoryInterface::class, TenantEloquentRepository::class);
        $this->app->bind(PersonRepositoryInterface::class, PersonEloquentRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressEloquentRepository::class);
        $this->app->bind(WorkOrderRepositoryInterface::class, WorkOrderEloquentRepository::class);
        $this->app->bind(WorkOrderItemRepositoryInterface::class, WorkOrderItemEloquentRepository::class);
        $this->app->bind(WorkOrderInstallmentRepositoryInterface::class, WorkOrderInstallmentEloquentRepository::class);
    }
}
