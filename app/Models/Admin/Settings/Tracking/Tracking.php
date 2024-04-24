<?php

namespace App\Models\Admin\Settings\Tracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = str()->uuid();
        });
    }

    public function trackable(): MorphTo
    {
        return $this->morphTo();
    }

    public function functionable(): MorphTo
    {
        return $this->morphTo();
    }
}
