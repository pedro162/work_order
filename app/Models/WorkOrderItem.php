<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'work_order_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'quantity',
        'external_code',
        'service_name',
        'gross_item_amount',
        'total_amount',
        'item_amount',
        'user_id',
        'user_update_id',
        'active',
        'work_order_id',
        'final_amount',
        'discount_amount',
        'surcharge_percentage',
        'surcharge_amount',
        'discount_percentage',
        'tenant_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'gross_item_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'item_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'surcharge_percentage' => 'decimal:4',
            'surcharge_amount' => 'decimal:2',
            'discount_percentage' => 'decimal:4',
            'active' => 'boolean',
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(
            WorkOrder::class,
            'work_order_id',
            'id'
        );
    }
}
