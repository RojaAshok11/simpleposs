<?php

namespace App\Models\Admin\Purchasereturn;

use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Creditdebit\Stockcd;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchasereturn\Purchasereturnitem;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Supplier\Supplier;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Purchasereturn extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [7, 'PR'];

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function purchasereturnitem(): HasMany
    {
        return $this->hasMany(Purchasereturnitem::class);
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
