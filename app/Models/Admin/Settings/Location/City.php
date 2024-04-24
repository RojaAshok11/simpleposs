<?php

namespace App\Models\Admin\Settings\Location;

use App\Models\Admin\Settings\Location\State;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [4, 'C'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
