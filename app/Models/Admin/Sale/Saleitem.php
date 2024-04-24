<?php

namespace App\Models\Admin\Sale;

use Illuminate\Support\Str;
use App\Models\Admin\Product\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Salereturn\Salereturnitem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saleitem extends Model
{
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function salereturnitem(): HasMany
    {
        return $this->hasMany(Salereturnitem::class);
    }

}
