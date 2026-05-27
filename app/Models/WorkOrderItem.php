<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderItem extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $attributeAliases = [
        'quantity' => 'qtd',
        'service_id' => 'servico_id',
        'gross_item_amount' => 'vrItemBruto',
        'total_amount' => 'vrTotal',
        'item_amount' => 'vrItem',
        'work_order_id' => 'ordem_servico_id',
        'final_amount' => 'vr_final',
        'discount_amount' => 'vr_desconto',
        'surcharge_percentage' => 'pct_acrescimo',
        'surcharge_amount' => 'vr_acrescimo',
        'discount_percentage' => 'pct_desconto',
    ];

    protected $table = 'servico_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'quantity',
        'service_id',
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
        'tenant_id'
    ];

    public function fill(array $attributes)
    {
        return parent::fill($this->normalizeFillableAttributes($attributes));
    }

    public function getAttribute($key)
    {
        return parent::getAttribute($this->attributeAliases[$key] ?? $key);
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($this->attributeAliases[$key] ?? $key, $value);
    }

    protected function normalizeFillableAttributes(array $attributes): array
    {
        $legacyToEnglish = array_flip($this->attributeAliases);

        $normalizedAttributes = [];

        foreach ($attributes as $key => $value) {
            $normalizedAttributes[$legacyToEnglish[$key] ?? $key] = $value;
        }

        return $normalizedAttributes;
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'ordem_servico_id', 'id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'servico_id', 'id');
    }
}
