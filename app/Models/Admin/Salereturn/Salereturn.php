<?php

namespace App\Models\Admin\Salereturn;

use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Creditdebit\Stockcd;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Salereturn\Salereturnitem;
use App\Models\Admin\Sale\Sale;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Salereturn extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [7, 'SR'];

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

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function salereturnitem(): HasMany
    {
        return $this->hasMany(Salereturnitem::class);
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
