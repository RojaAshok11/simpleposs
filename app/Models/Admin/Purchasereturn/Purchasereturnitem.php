<?php

namespace App\Models\Admin\Purchasereturn;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchasereturn\Purchasereturn;
use App\Models\Admin\Purchase\Purchaseitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchasereturnitem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseitem(): BelongsTo
    {
        return $this->belongsTo(Purchaseitem::class);
    }

    public function purchasereturn(): BelongsTo
    {
        return $this->belongsTo(Purchasereturn::class);
    }
}
