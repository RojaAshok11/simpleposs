<?php

namespace App\Models\Commontraits\CommonTraits;

use App\Models\Admin\Auth\User;
use App\Models\Admin\Settings\Tracking\Tracking;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait GeneralTraits
{
    public function createdby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    public function functionable(): MorphMany
    {
        return $this->morphMany(Tracking::class, 'functionable');
    }

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 1 ? true : false,
        );
    }

    public function scopeActive(): void
    {
        $this->where('active', true);
    }

}
