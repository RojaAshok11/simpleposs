<?php

namespace App\Models\Admin\Settings\Generalsettings;

use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;

class Emailsetting extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [3, 'ES', 'ADMIN'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];
}
