<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderInstallment extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $attributeAliases = [
        'work_order_id' => 'ordem_servico_id',
        'payment_method_id' => 'forma_pagamento_id',
        'financial_operator_id' => 'operador_financeiro_id',
        'payment_plan_id' => 'plano_pagamento_id',
        'branch_id' => 'filial_id',
        'document_number' => 'nr_doc',
        'manual_due_date' => 'vencimento_manual',
        'manual_due_date_at' => 'dt_vencimento_manual',
        'charge_amount' => 'vr_cobranca',
        'surcharge_amount' => 'vr_acrescimo',
        'final_amount' => 'vr_final',
    ];

    protected $table = 'work_order_installments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'work_order_id',
        'payment_method_id',
        'financial_operator_id',
        'payment_plan_id',
        'branch_id',
        'document_number',
        'manual_due_date',
        'manual_due_date_at',
        'charge_amount',
        'surcharge_amount',
        'final_amount',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
