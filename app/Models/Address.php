<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use SoftDeletes;
    use HasFactory;
    use BelongsToTenant;

    protected $table = 'addresses';

    protected $primaryKey = 'id';

    protected $fillable = [
        'person_id',
        'type',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'is_primary',
        'active',
        'user_id',
        'user_update_id',
        'tenant_id',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
