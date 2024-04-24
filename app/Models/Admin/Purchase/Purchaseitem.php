<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchaseitem extends Model
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
}
