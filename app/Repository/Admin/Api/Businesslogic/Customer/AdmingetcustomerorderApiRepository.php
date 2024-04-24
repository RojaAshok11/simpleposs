<?php

namespace App\Repository\Admin\Api\Businesslogic\Customer;

use App\Http\Resources\Admin\Customer\CustomerorderhistoryCollection;
use App\Models\Admin\Sale\Sale;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmingetcustomerorderApiRepository;
use Illuminate\Database\Eloquent\Builder;

class AdmingetcustomerorderApiRepository implements IAdmingetcustomerorderApiRepository
{
    public function admingetcustomerorder()
    {
        return [true,
            new CustomerorderhistoryCollection(Sale::whereHas('customer', fn(Builder $q) =>
                $q->where('uuid', request()->uuid))
                    ->latest()
                    ->paginate(10)),
            'Customer List'];
    }
}
