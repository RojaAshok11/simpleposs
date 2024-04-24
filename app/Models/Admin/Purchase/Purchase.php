<?php

namespace App\Models\Admin\Purchase;

use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Creditdebit\Stockcd;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Admin\Supplier\Supplier;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Purchase extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'P'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseitem(): HasMany
    {
        return $this->hasMany(Purchaseitem::class);
    }

    public function stockcdable(): MorphMany
    {
        return $this->morphMany(Stockcd::class, 'stockcdable');
    }

    public function amountcdable(): MorphMany
    {
        return $this->morphMany(Amountcd::class, 'amountcdable');
    }
}
