<?php

namespace App\Models\Admin\Settings\Generalsettings;

use Illuminate\Database\Eloquent\Model;

class Companysetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];
}
