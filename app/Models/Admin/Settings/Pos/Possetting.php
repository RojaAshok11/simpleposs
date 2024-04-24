<?php

namespace App\Models\Admin\Settings\Pos;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Possetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    protected function isHold(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 1 ? true : false,
        );
    }

    public function scopeIshold(): void
    {
        $this->where('is_hold', true);
    }

    protected function isHoldreference(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 1 ? true : false,
        );
    }

    public function scopeIsholdreference(): void
    {
        $this->where('is_holdreference', true);
    }
}
