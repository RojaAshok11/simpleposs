<?php

namespace App\Repository\Admin\Api\Businesslogic\Expense;

use App\Http\Resources\Admin\Expense\ExpenseCollection;
use App\Models\Admin\Expense\Expense;
use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use App\Repository\Admin\Api\Interfacelayer\Expense\IAdminexpenseApiRepository;
use Carbon\Carbon;

class AdminexpenseApiRepository implements IAdminexpenseApiRepository
{
    public function admincreateoreditexpense()
    {
        Expense::updateorCreate(
            [
                'uuid' => request()->uuid,
            ], [
                "name" => request()->name,
                "date" => request()->date ? Carbon::parse(request()->date)->format('Y-m-d') : null,
                "expensecategory_id" => Expensecategory::where('uuid', request()->expensecategory_uuid)->first()->id,
                "amount" => request()->amount,
                "note" => request()->note,
                "active" => request()->active,
            ]);

        return [true, null, 'Supplier Created Successfully'];
    }

    public function adminexpenselist()
    {
        return [true,
            new ExpenseCollection(Expense::query()
                    ->where(function ($query) {
                        $query->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('name', 'like', '%' . request('search') . '%');
                    })
                    ->active()
                    ->latest()
                    ->paginate(10)),
            'Supplier List'];
    }

    public function adminshowexpense()
    {
        $expense = Expense::where('uuid', request()->uuid)->first();
        $data['uuid'] = $expense->uuid ? $expense->uuid : '';
        $data['uniqid'] = $expense->uniqid ? $expense->uniqid : '';
        $data['name'] = $expense->name ? $expense->name : '';
        $data['date'] = $expense->date ? Carbon::parse($expense->date)->format('d-m-Y') : '';
        $data['expensecategory'] = $expense->expensecategory_id ? $expense->expensecategory->name : '';
        $data['amount'] = $expense->amount ? $expense->amount : '';
        $data['note'] = $expense->note ? $expense->note : '';
        $data['active'] = $expense->active ? 'Yes' : 'No';

        return [true, $data, 'Show Expense'];
    }
}
