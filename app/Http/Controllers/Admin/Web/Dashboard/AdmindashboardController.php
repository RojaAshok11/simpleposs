<?php

namespace App\Http\Controllers\Admin\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Supplier\Supplier;
use Carbon\Carbon;
use Illuminate\View\View;

class AdmindashboardController extends Controller
{
    public function dashboard(): view
    {
        $totalsupplier = Supplier::where('active', true)->count();
        $totalcustomer = Customer::where('active', true)->count();
        $totalsales = Sale::where('active', true)->count();
        $totalpurchases = Purchase::where('active', true)->count();

        // Sales Details

        $todaysale = Sale::where('active', true)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $yesterdaysale = Sale::where('active', true)
            ->whereDate('created_at', Carbon::yesterday())
            ->count();

        $weeksale = Sale::where('active', true)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $lastweeksale = Sale::where('active', true)
            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
            ->count();

        $monthsale = Sale::where('active', true)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $lastmonthsale = Sale::where('active', true)
            ->whereMonth('created_at', Carbon::now()->subMonth())
            ->count();

        $yearsale = Sale::where('active', true)
            ->whereYear('created_at', date('Y'))
            ->count();

        $previousyearsale = Sale::where('active', true)
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

        $topsaletoday[] = ['Sale', 'Today'];
        foreach ($stockcdableToday as $key => $value) {
            $topsaletoday[++$key] = [$value->name, (int) $value->saleitem_count];
        }

        // Sales Items Month

        $stockcdableMonth = Product::where('active', true)
            ->whereHas('saleitem', function ($q) {
                $q->whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'));
            })->withCount('saleitem')
            ->orderBy('saleitem_count', 'desc')
            ->take(5)
            ->get();

        $topsalemonth[] = ['Sale', 'Month'];
        foreach ($stockcdableMonth as $key => $value) {
            $topsalemonth[++$key] = [$value->name, (int) $value->saleitem_count];
        }

        return view('admin.dashboard.admindashboard', compact('totalsupplier', 'totalcustomer', 'totalsales',
            'totalpurchases', 'todaysale', 'yesterdaysale', 'weeksale', 'monthsale', 'topsaletoday', 'topsalemonth', 'yearsale', 'previousyearsale', 'lastweeksale', 'lastmonthsale'));

    }

}
