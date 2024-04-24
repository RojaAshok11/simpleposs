<?php

namespace App\Models\Admin\Customer;

use App\Models\Admin\Sale\Sale;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'C'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

}
