<?php

namespace App\Repository\Admin\Api\Businesslogic\Order;

use App\Http\Resources\Admin\Order\OrderhistoryCollection;
use App\Http\Resources\Admin\Order\ShoworderResource;
use App\Models\Admin\Sale\Sale;
use App\Repository\Admin\Api\Interfacelayer\Order\IOrderhistoryApiRepository;

class OrderhistoryApiRepository implements IOrderhistoryApiRepository
{
    public function individualhistory()
    {

        return [true,
            new OrderhistoryCollection(Sale::where('user_id', auth()->user()->id)
                    ->where(fn($q) =>
                        $q->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
                            ->orWhereHas('customer', fn($q) => $q->where('phone', 'like', '%' . request('search') . '%'))
                    )
                    ->latest()
                    ->paginate(10)),
            'individualhistory'];
    }

    public function adminoverallorderhistory()
    {
        return [true,
            new OrderhistoryCollection(Sale::where(fn($q) =>
                $q->where('uniqid', 'like', '%' . request('search') . '%')
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
                    ->orWhereHas('customer', fn($q) => $q->where('phone', 'like', '%' . request('search') . '%'))
            )
                    ->latest()
                    ->paginate(10)),
            'adminoverallorderhistory'];
    }

    public function showorderbyuuid()
    {
        return [true,
            ShoworderResource::collection(Sale::where('uuid', request('uuid'))->get()),
            'showorderbyuuid'];
    }

}
