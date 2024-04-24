<?php

namespace App\Repository\Admin\Api\Businesslogic\Dashboard;

use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Expense\Expense;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Supplier\Supplier;
use App\Repository\Admin\Api\Interfacelayer\Dashboard\IAdmindashboardApiRepository;
use Carbon\Carbon;

class AdmindashboardApiRepository implements IAdmindashboardApiRepository
{
    public function admindashboard()
    {
        $data['total_customer'] = Customer::where('active', true)->count();
        $data['total_supplier'] = Supplier::where('active', true)->count();
        $data['total_sale'] = Sale::where('active', true)->count();
        $data['total_purchase'] = Purchase::where('active', true)->count();
        $data['total_expense'] = Expense::sum('amount');

        // Sales Details

        $data['todaysale'] = Sale::where('active', true)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $data['yesterdaysale'] = Sale::where('active', true)
            ->whereDate('created_at', Carbon::yesterday())
            ->count();

        $data['weeksale'] = Sale::where('active', true)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $data['lastweeksale'] = Sale::where('active', true)
            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();

        $data['monthsale'] = Sale::where('active', true)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $data['lastmonthsale'] = Sale::where('active', true)
            ->whereMonth('created_at', Carbon::now()->subMonth())
            ->count();

        $data['yearsale'] = Sale::where('active', true)
            ->whereYear('created_at', date('Y'))
            ->count();

        $data['previousyearsale'] = Sale::where('active', true)
            ->whereYear('created_at', Carbon::now()->subYear())
            ->count();

        // Sales Items Today

        $stockcdableToday = Product::where('active', true)
            ->whereHas('saleitem', function ($q) {
                $q->whereDate('created_at', Carbon::today());
            })->withCount('saleitem')
            ->orderBy('saleitem_count', 'desc')
            ->take(5)
            ->get();

        $data['topsaletoday'] = [];
        foreach ($stockcdableToday as $key => $value) {
            $data['topsaletoday'][$key]['product'] = $value->name;
            $data['topsaletoday'][$key]['count'] = (int) $value->saleitem_count;
        }

        // // Sales Items Month

        $stockcdableMonth = Product::where('active', true)
            ->whereHas('saleitem', function ($q) {
                $q->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'));
            })->withCount('saleitem')
            ->orderBy('saleitem_count', 'desc')
            ->take(5)
            ->get();

        $data['topsalemonth'] = [];
        foreach ($stockcdableMonth as $key => $value) {
            $data['topsalemonth'][$key]['product'] = $value->name;
            $data['topsalemonth'][$key]['count'] = (int) $value->saleitem_count;
        }

        return [true, $data,
            'admindashboard'];
    }
}
