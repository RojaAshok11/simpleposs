<?php

namespace App\Repository\Admin\Api\Businesslogic\Customer;

use App\Http\Resources\Admin\Customer\CustomerlistCollection;
use App\Models\Admin\Customer\Customer;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmincustomerApiRepository;

class AdmincustomerApiRepository implements IAdmincustomerApiRepository
{
    public function admincustomerlistandsearch()
    {
        return [true,
            new CustomerlistCollection(Customer::query()
                    ->where(fn($q) =>
                        $q->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('name', 'like', '%' . request('search') . '%')
                            ->orWhere('phone', 'like', '%' . request('search') . '%')
                            ->orWhere('email', 'like', '%' . request('search') . '%'),
                    )
                    ->active()
                    ->latest()
                    ->paginate(10)),
            'Customer List'];
    }

    public function admincreatecustomer()
    {
        Customer::updateorCreate(
            [
                'uuid' => request('uuid'),
            ],
            [
                'name' => request('name'),
                'phone' => request('phone'),
                'email' => request('email'),
                'active' => request('active'),
                'note' => request('note'),
            ]);
        return [true, null, 'Customer Created Successfully'];
    }

    public function adminshowcustomer()
    {
        $customer = Customer::where('uuid', request()->uuid)->first();
        $data['uuid'] = $customer->uuid ? $customer->uuid : '';
        $data['uniqid'] = $customer->uniqid ? $customer->uniqid : '';
        $data['name'] = $customer->name ? $customer->name : '';
        $data['phone'] = $customer->phone ? $customer->phone : '';
        $data['email'] = $customer->email ? $customer->email : '';
        $data['note'] = $customer->note ? $customer->note : '';
        $data['active'] = $customer->active ? 'Yes' : 'No';

        return [true, $data, 'Show Customer'];
    }
}
