<?php

use App\Http\Controllers\Admin\Web\Customer\CustomerController;
use App\Http\Controllers\Admin\Web\Dashboard\AdmindashboardController;
use App\Http\Controllers\Admin\Web\Expense\ExpenseController;
use App\Http\Controllers\Admin\Web\Pos\PosController;
use App\Http\Controllers\Admin\Web\Product\ProductController;
use App\Http\Controllers\Admin\Web\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Web\Reports\Expensereport\ExpensereportController;
use App\Http\Controllers\Admin\Web\Reports\Inventoryreport\CurrentstockreportController;
use App\Http\Controllers\Admin\Web\Reports\Inventoryreport\StockreportController;
use App\Http\Controllers\Admin\Web\Reports\Logreport\LogininfoController;
use App\Http\Controllers\Admin\Web\Reports\Logreport\TrackingController;
use App\Http\Controllers\Admin\Web\Reports\Purchasereport\PurchasereportController;
use App\Http\Controllers\Admin\Web\Reports\Reports\AdminreportsController;
use App\Http\Controllers\Admin\Web\Reports\Salereport\AmountcdreportController;
use App\Http\Controllers\Admin\Web\Reports\Salereport\SalereportController;
use App\Http\Controllers\Admin\Web\Sale\SaleController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\CompanysettingController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\EmailsettingController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\FcmsettingController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\GatewaysettingController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\SmssettingController;
use App\Http\Controllers\Admin\Web\Settings\Generalsetting\ThemesettingController;
use App\Http\Controllers\Admin\Web\Settings\Location\CityController;
use App\Http\Controllers\Admin\Web\Settings\Location\StateController;
use App\Http\Controllers\Admin\Web\Settings\Mastersetting\ExpensecategoryController;
use App\Http\Controllers\Admin\Web\Settings\Mastersetting\ProductcategoryController;
use App\Http\Controllers\Admin\Web\Settings\Mastersetting\UomController;
use App\Http\Controllers\Admin\Web\Settings\Notification\AlertController;
use App\Http\Controllers\Admin\Web\Settings\Notification\PushnotificationController;
use App\Http\Controllers\Admin\Web\Settings\Pos\PossettingController;
use App\Http\Controllers\Admin\Web\Settings\Settings\AdminsettingsController;
use App\Http\Controllers\Admin\Web\Settings\Support\FaqController;
use App\Http\Controllers\Admin\Web\Settings\Support\SupportController;
use App\Http\Controllers\Admin\Web\Settings\Systemsetting\CurrencymasterController;
use App\Http\Controllers\Admin\Web\Settings\Systemsetting\TimezonemasterController;
use App\Http\Controllers\Admin\Web\Settings\User\UserController;
use App\Http\Controllers\Admin\Web\Supplier\SupplierController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'preventbackbutton'], 'prefix' => 'admin'], function () {
    // Dashboard
    Route::get('/admindashboard', [AdmindashboardController::class, 'dashboard'])->name('admindashboard');

    //Supplier
    Route::get('/supplier', [SupplierController::class, 'supplier'])->name('adminsupplier');

    // Products
    Route::controller(ProductController::class)
        ->group(function () {
            Route::get('/product', 'product')->name('adminproduct');
            Route::get('/printbarcode/{count}/{uniqid}', 'printbarcode')->name('printbarcode');
        });

    //Stock adjustment
    Route::get('/stockadjustment', [ProductController::class, 'stockadjustment'])->name('adminstockadjustment');

    //Stock
    Route::get('/stockhistory/{id}', [ProductController::class, 'stockhistory'])->name('stockhistory');

    // sale
    Route::controller(SaleController::class)
        ->group(function () {
            Route::get('/sale', 'sale')->name('adminsale');
            Route::get('/salehold', 'salehold')->name('adminsalehold');
            Route::get('/salecreateoredit/{type?}/{id?}', 'salecreateoredit')->name('salecreateoredit');
            Route::get('/saleprint/{id}', 'print')->name('saleprint');
            Route::get('/salereturn', 'salereturn')->name('adminsalereturn');
            Route::get('/salereturncreate/{id?}', 'salereturncreate')->name('salereturncreate');
        });

    // Purchase
    Route::controller(PurchaseController::class)
        ->group(function () {
            Route::get('/purchase', 'purchase')->name('adminpurchase');
            Route::get('/purchasecreateoredit/{id?}', 'purchasecreateoredit')->name('purchasecreateoredit');
            Route::get('/purchasereturn', 'purchasereturn')->name('adminpurchasereturn');
            Route::get('/purchasereturncreate', 'purchasereturncreate')->name('purchasereturncreate');
        });

    //Customer
    Route::get('/customer', [CustomerController::class, 'customer'])->name('admincustomer');

    //Expense
    Route::get('/expense', [ExpenseController::class, 'expense'])->name('adminexpense');

    // Reports
    Route::get('/reports', [AdminreportsController::class, 'index'])->name('adminreports');

    // Log Reports
    Route::get('logininfo', [LogininfoController::class, 'logininfo'])->name('logininfo');
    Route::get('tracking', [TrackingController::class, 'tracking'])->name('tracking');

    // Sale Reports
    Route::get('/salesreport', [SalereportController::class, 'salesreport'])->name('salesreport');
    Route::get('/saleitemsreport', [SalereportController::class, 'saleitemsreport'])->name('saleitemsreport');

    // Amount Credit Debit
    Route::get('/amountcdreport', [AmountcdreportController::class, 'amountcdreport'])->name('amountcdreport');

    //Purchase Reports
    Route::get('/purchasereport', [PurchasereportController::class, 'purchasereport'])->name('purchasereport');
    Route::get('/purchaseitemreport', [PurchasereportController::class, 'purchaseitemreport'])->name('purchaseitemreport');

    //Expense Reports
    Route::get('/expensereport', [ExpensereportController::class, 'expensereport'])->name('expensereport');

    //Stock Reports
    Route::get('/stockreport', [StockreportController::class, 'stockreport'])->name('stockreport');
    Route::get('/currentstockreport', [CurrentstockreportController::class, 'currentstockreport'])->name('currentstockreport');

    // Settings
    Route::get('/settings', [AdminsettingsController::class, 'index'])->name('adminsettings');

    // User Settings
    Route::controller(UserController::class)
        ->group(function () {
            Route::get('usercreateoredit', 'usercreateoredit')->name('usercreateoredit');
            Route::get('userchangepassword', 'userchangepassword')->name('userchangepassword');
            Route::get('userrole', 'userrole')->name('userrole');
            Route::get('permission/{id}', 'permission')->name('permission');
        });

    // Master Settings
    // Product Category
    Route::get('productcategory', [ProductcategoryController::class, 'productcategory'])->name('adminproductcategory');
    //UOM setting
    Route::get('/uom', [UomController::class, 'uom'])->name('adminuom');
    //Expense Category
    Route::get('/expensecategory', [ExpensecategoryController::class, 'expensecategory'])->name('adminexpensecategory');

    // Location
    Route::get('state', [StateController::class, 'state'])->name('state');
    Route::get('city', [CityController::class, 'city'])->name('city');

    //FAQ
    Route::controller(FaqController::class)
        ->group(function () {
            Route::get('/faq', 'faq')->name('adminfaq');
            Route::get('/faqcreate', 'create')->name('faqcreate');
            Route::get('/faqedit/{id}', 'edit')->name('faqedit');
        });

    //Support
    Route::controller(SupportController::class)
        ->group(function () {
            Route::get('/support', 'support')->name('adminsupport');
            Route::get('/supportcreate', 'create')->name('supportcreate');
            Route::get('/supportedit/{id}', 'edit')->name('supportedit');
        });

    // Notifaction Setting
    Route::controller(AlertController::class)
        ->group(function () {

            Route::get('alert', 'alert')->name('adminalert');
            // Route::get('/poscreate', 'create')->name('poscreate');
            // Route::get('/posedit/{id}', 'edit')->name('posedit');
        });

    //POSPUSH NOTIFIACTION
    Route::get('pushnotification', [PushnotificationController::class, 'pushnotification'])->name('adminpushnotification');

    // General Setting
    // Theme
    Route::get('themesetting', [ThemesettingController::class, 'themesetting'])->name('adminthemesetting');
    // Email
    Route::get('emailsetting', [EmailsettingController::class, 'emailsetting'])->name('adminemailsetting');
    // Gateway
    Route::get('gatewaysetting', [GatewaysettingController::class, 'gatewaysetting'])->name('admingateway');
    // SMS
    Route::get('smssetting', [SmssettingController::class, 'smssetting'])->name('adminsmssetting');
    // Company
    Route::get('companysetting', [CompanysettingController::class, 'companysetting'])->name('admincompanysetting');
    // Fcm
    Route::get('fcmsetting', [FcmsettingController::class, 'fcmsetting'])->name('adminfcmsetting');

    // Pos setting
    Route::get('possetting', [PossettingController::class, 'possetting'])->name('adminpossetting');

    // System setting
    Route::get('currencymaster', [CurrencymasterController::class, 'currencymaster'])->name('admincurrencymaster');
    Route::get('timezonemaster', [TimezonemasterController::class, 'timezonemaster'])->name('admintimezonemaster');

    // POS
    Route::get('/salepos/{type?}/{id?}', [PosController::class, 'salepos'])->name('salepos');
});
