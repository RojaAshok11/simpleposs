<?php

namespace App\Models\Admin\Creditdebit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Amountcd extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_id = auth()->id();
            $model->uuid = (string) Str::uuid();
        });
    }

    public function amountcdable(): MorphTo
    {
        return $this->morphTo();
    }

}
