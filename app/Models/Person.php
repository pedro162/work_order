<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    use BelongsToTenant;

    protected $table = 'people';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'first_name',
        'last_name',
        'optional_name',
        'document',
        'extra_document',
        'birth_date',
        'gender',
        'type',
        'user_id',
        'user_update_id',
        'active',
        'tenant_id'
    ];
}
