<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    use BelongsToTenant;
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'services';
    protected $fillable = [
        'name',
        'description',
        'value',
        'unit',
        'user_id',
        'user_update_id',
        'type',
        'active',
        'tenant_id'
    ];
}
