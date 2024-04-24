<?php

namespace App\Models\Admin\Settings\Notification;

use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    use BootTraits, GeneralTraits;

    public static $prefix = [5, 'ALT'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];
}
