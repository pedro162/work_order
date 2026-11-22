<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrder extends Model
{
    use SoftDeletes;
    use HasFactory;
    use BelongsToTenant;

    protected $table = 'work_orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'external_code',
        'total_amount',
        'status',
        'notes',
        'file_path',
        'person_id',
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
        'cancel_reason',
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
