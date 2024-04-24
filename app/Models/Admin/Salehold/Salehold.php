<?php

namespace App\Models\Admin\Salehold;

use App\Models\Admin\Customer\Customer;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salehold extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'SH'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleholditem(): HasMany
    {
        return $this->hasMany(Saleholditem::class);
    }
}
