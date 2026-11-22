<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderInstallment extends Model
{
    use SoftDeletes;
    use HasFactory;
    use BelongsToTenant;

    protected $table = 'work_order_installments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'work_order_id',
        'external_code',
        'payment_method',
        'document_number',
        'charge_amount',
        'surcharge_amount',
        'final_amount',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
