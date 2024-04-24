<?php

namespace App\Repository\Admin\Api\Businesslogic\Support;

use App\Models\Admin\Settings\Support\Support;
use App\Repository\Admin\Api\Interfacelayer\Support\IAdminsupportApiRepository;

class AdminsupportApiRepository implements IAdminsupportApiRepository
{
    public function adminsupport()
    {
        return [true,
            Support::where('type', request('type'))
                ->where('panel', request('type'))
                ->select('description')
                ->get(),
            'Support data'];
    }
}
