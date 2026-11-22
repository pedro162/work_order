<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tenants';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'trade_name',
        'slug',
        'document',
        'email',
        'phone',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    /**
     * Users belonging to the tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'tenant_id',
            'id'
        );
    }

    /**
     * People belonging to the tenant.
     */
    public function people(): HasMany
    {
        return $this->hasMany(
            Person::class,
            'tenant_id',
            'id'
        );
    }

    /**
     * Addresses belonging to the tenant.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(
            Address::class,
            'tenant_id',
            'id'
        );
    }

    /**
     * Work orders belonging to the tenant.
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(
            WorkOrder::class,
            'tenant_id',
            'id'
        );
    }

    /**
     * Work order items belonging to the tenant.
     */
    public function workOrderItems(): HasMany
    {
        return $this->hasMany(
            WorkOrderItem::class,
            'tenant_id',
            'id'
        );
    }

    /**
     * Work order installments belonging to the tenant.
     */
    public function workOrderInstallments(): HasMany
    {
        return $this->hasMany(
            WorkOrderInstallment::class,
            'tenant_id',
            'id'
        );
    }
}
