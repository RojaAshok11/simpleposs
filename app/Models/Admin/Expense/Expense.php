<?php

namespace App\Models\Admin\Expense;

use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use App\Models\Commontraits\CommonTraits\BootTraits;
use App\Models\Commontraits\CommonTraits\GeneralTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Expense extends Model
{
    use BootTraits, GeneralTraits;

    public static $prefix = [6, 'E'];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y h:i:s',
        'updated_at' => 'datetime:d-M-Y h:i:s',
    ];

    public function expensecategory()
    {
        return $this->belongsTo(Expensecategory::class);
    }

    public function amountcdable(): MorphMany
    {
        return $this->morphMany(Amountcd::class, 'amountcdable');
    }
}
