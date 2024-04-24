<?php

namespace App\Models\Commontraits\AuthTraits;

use App\Models\Admin\Settings\Tracking\Logininfo;
use App\Models\Admin\Settings\Tracking\Tracking;
use App\Models\Miscellaneous\PasswordSecurity;
use Cache;
use Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAuthTrait
{
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Hash::make($value),
        );
    }

    public function isOnline(): Bool
    {
        return Cache::has('user-is-online-' . $this->uuid);
    }

    public function passwordSecurity(): HasOne
    {
        return $this->hasOne(PasswordSecurity::class);
    }

    public function trackable(): MorphMany
    {
        return $this->morphMany(Tracking::class, 'trackable');
    }

    public function functionable(): MorphMany
    {
        return $this->morphMany(Tracking::class, 'functionable');
    }

    public function logininfoable(): MorphMany
    {
        return $this->morphMany(Logininfo::class, 'logininfoable');
    }

}
