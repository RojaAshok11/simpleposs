<?php

namespace App\Models\Admin\Product;

use App\Models\Admin\Creditdebit\Stockcd;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Admin\Settings\Mastersettings\Productcategory;
use App\Models\Admin\Settings\Mastersettings\Uom;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'P'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function productcategory(): BelongsTo
    {
        return $this->belongsTo(Productcategory::class);
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class);
    }

    public function saleitem(): HasMany
    {
        return $this->hasMany(Saleitem::class);
    }

    public function stockcdable(): MorphMany
    {
        return $this->morphMany(Stockcd::class, 'stockcdable');
    }

    protected function isNonveg(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 1 ? true : false,
        );
    }

    public function scopeIsnonveg(): void
    {
        $this->where('is_nonveg', true);
    }
}
