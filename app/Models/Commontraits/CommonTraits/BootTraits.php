<?php

namespace App\Models\Commontraits\CommonTraits;

use App\Models\Miscellaneous\Uniqidhelper;
use Illuminate\Database\Eloquent\SoftDeletes;

trait BootTraits
{
    use SoftDeletes;

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            Uniqidhelper::autogenerateid(self::$prefix[0], self::$prefix[1], $model);
        });
        static::updating(function ($model) {
            Uniqidhelper::autogenerateid(false, false, $model);
        });
    }
}
