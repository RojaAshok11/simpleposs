<?php

namespace App\Repository\Admin\Api\Businesslogic\Settings\Uom;

use App\Models\Admin\Settings\Mastersettings\Uom;
use App\Repository\Admin\Api\Interfacelayer\Settings\Uom\IAdminuomApiRepository;

class AdminuomApiRepository implements IAdminuomApiRepository
{
    public function admingetuomlist()
    {
        return [true, Uom::where('active', true)->select('uuid', 'name')->get(), 'UOM List'];
    }
}
