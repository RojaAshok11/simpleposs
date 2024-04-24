<?php

namespace App\Models\Admin\Salereturn;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Salereturn\Salereturn;
use App\Models\Admin\Sale\Saleitem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salereturnitem extends Model
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

    public function saleitem(): BelongsTo
    {
        return $this->belongsTo(Saleitem::class);
    }

    public function salereturn(): BelongsTo
    {
        return $this->belongsTo(Salereturn::class);
    }
}
