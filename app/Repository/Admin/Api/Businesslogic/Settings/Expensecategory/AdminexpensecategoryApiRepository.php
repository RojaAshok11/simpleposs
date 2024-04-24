<?php

namespace App\Repository\Admin\Api\Businesslogic\Settings\Expensecategory;

use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use App\Repository\Admin\Api\Interfacelayer\Settings\Expensecategory\IAdminexpensecategoryApiRepository;

class AdminexpensecategoryApiRepository implements IAdminexpensecategoryApiRepository
{
    public function admingetexpensecategorylist()
    {
        return [true, Expensecategory::where('active', true)->select('uuid', 'name')->get(), 'UOM List'];
    }
}
