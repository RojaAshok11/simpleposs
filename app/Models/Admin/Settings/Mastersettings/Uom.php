<?php

namespace App\Models\Admin\Settings\Mastersettings;

use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [4, 'U'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];
}
