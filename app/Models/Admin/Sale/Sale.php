<?php

namespace App\Models\Admin\Sale;

use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Creditdebit\Stockcd;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sale extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'S'];

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function saleitem(): HasMany
    {
        return $this->hasMany(Saleitem::class);
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
