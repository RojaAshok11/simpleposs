<?php

namespace App\Repository\Admin\Api\Businesslogic\Supplier;

use App\Http\Resources\Admin\Supplier\SupplierCollection;
use App\Models\Admin\Supplier\Supplier;
use App\Repository\Admin\Api\Interfacelayer\Supplier\IAdminsupplierApiRepository;

class AdminsupplierApiRepository implements IAdminsupplierApiRepository
{
    public function admincreateoreditsupplier()
    {
        Supplier::updateorCreate(
            [
                'uuid' => request()->uuid,
            ], [
                "name" => request()->name,
                "phone" => request()->phone,
                "email" => request()->email,
                "gst" => request()->gst,
                "pan" => request()->pan,
                "cpname" => request()->cpname,
                "cpphone" => request()->cpphone,
                "cpmail" => request()->cpmail,
                "address" => request()->address,
                "note" => request()->note,
                "active" => request()->active,
            ]);

        return [true, null, 'Supplier Created Successfully'];
    }

    public function adminsupplierlist()
    {
        return [true,

            new SupplierCollection(Supplier::query()
                    ->where(function ($query) {
                        $query->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('name', 'like', '%' . request('search') . '%')
                            ->orWhere('phone', 'like', '%' . request('search') . '%')
                            ->orWhere('cpname', 'like', '%' . request('search') . '%');
                    })
                    ->active()
                    ->latest()
                    ->paginate(10)),
            'Supplier List'];
    }

    public function adminshowsupplier()
    {
        $supplier = Supplier::where('uuid', request()->uuid)->first();
        $data['uuid'] = $supplier->uuid ? $supplier->uuid : '';
        $data['uniqid'] = $supplier->uniqid ? $supplier->uniqid : '';
        $data['name'] = $supplier->name ? $supplier->name : '';
        $data['phone'] = $supplier->phone ? $supplier->phone : '';
        $data['email'] = $supplier->email ? $supplier->email : '';
        $data['gst'] = $supplier->gst ? $supplier->gst : '';
        $data['pan'] = $supplier->pan ? $supplier->pan : '';
        $data['cpname'] = $supplier->cpname ? $supplier->cpname : '';
        $data['cpphone'] = $supplier->cpphone ? $supplier->cpphone : '';
        $data['cpmail'] = $supplier->cpmail ? $supplier->cpmail : '';
        $data['address'] = $supplier->address ? $supplier->address : '';
        $data['note'] = $supplier->note ? $supplier->note : '';
        $data['active'] = $supplier->active ? 'Yes' : 'No';

        return [true, $data, 'Show Supplier'];
    }
}
