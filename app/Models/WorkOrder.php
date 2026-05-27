<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'work_orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'total_amount',
        'status',
        'notes',
        'file_path',
        'person_id',
        'rca_person_id',
        'branch_id',
        'user_id',
        'user_update_id',
        'active',
        'final_amount',
        'discount_amount',
        'surcharge_percentage',
        'surcharge_amount',
        'discount_percentage',
        'is_billed',
        'billed_at',
        'canceled_at',
        'completed_at',
        'billed_person_id',
        'canceled_person_id',
        'completed_person_id',
        'professional_id',
        'cancel_reason_id',
        'type',
        'is_quote',
        'tenant_id'
    ];

    public function getTable()
    {
        return $this->table;
    }

    public function items()
    {
        return $this->hasMany(WorkOrderItem::class, 'work_order_id', 'id');
    }

    public function installments()
    {
        return $this->hasMany(WorkOrderInstallment::class, 'work_order_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }
}
