<?php

namespace App\Models\Admin\Settings\Generalsettings;

use App\Models\Admin\Settings\Generalsettings\Smssetting;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Smssetting extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [3, 'SS', 'ADMIN'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    protected function isDefault(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value == 1 ? true : false,
        );
    }
}
