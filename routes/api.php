<?php

use App\Http\Controllers\Admin\Api\Auth\AdminlogoutApiController;
use App\Http\Controllers\Admin\Api\Auth\AdminpasswordloginApiController;
use App\Http\Controllers\Admin\Api\Customer\AdmincustomerApiController;
use App\Http\Controllers\Admin\Api\Customer\AdmingetcustomerorderApiController;
use App\Http\Controllers\Admin\Api\Dashboard\AdmindashboardApiController;
use App\Http\Controllers\Admin\Api\Expense\AdminexpenseApiController;
use App\Http\Controllers\Admin\Api\Faq\AdminfaqApiController;
use App\Http\Controllers\Admin\Api\Fcm\AdminfcmApiController;
use App\Http\Controllers\Admin\Api\Notification\AdminnotificationApiController;
use App\Http\Controllers\Admin\Api\Order\AdminorderhistoryApiController;
use App\Http\Controllers\Admin\Api\Order\AdminplaceorderApiController;
use App\Http\Controllers\Admin\Api\Possetting\AdminpossettingApiController;
use App\Http\Controllers\Admin\Api\Productcategory\AdminproductcategoryApiController;
use App\Http\Controllers\Admin\Api\Product\AdminproductApiController;
use App\Http\Controllers\Admin\Api\Profile\AdminpofileApiController;
use App\Http\Controllers\Admin\Api\Purchasereturn\AdminpurchasereturnApiController;
use App\Http\Controllers\Admin\Api\Purchase\AdminpurchaseApiController;
use App\Http\Controllers\Admin\Api\Salereturn\AdminsalereturneApiController;
use App\Http\Controllers\Admin\Api\Settings\Expensecategory\AdminexpensecategoryApiController;
use App\Http\Controllers\Admin\Api\Settings\Uom\AdminuomApiController;
use App\Http\Controllers\Admin\Api\Supplier\AdminsupplierApiController;
use App\Http\Controllers\Admin\Api\Support\AdminsupportApiController;
use Illuminate\Support\Facades\Route;

//AUTH
Route::group(['prefix' => 'v1/admin'], function () {
    // LOGIN
    Route::post('adminpasswordlogin', [AdminpasswordloginApiController::class, 'adminpasswordlogin']);
});

Route::group(['prefix' => 'v1/admin', 'middleware' => 'auth:api', 'scopes:admin'], function () {

    // PROFILE
    Route::controller(AdminpofileApiController::class)
        ->group(function () {
            Route::get('admingetprofile', 'admingetprofile');
            Route::post('adminupdateprofile', 'adminupdateprofile');
            Route::post('adminchangepassword', 'adminchangepassword');
            Route::post('adminchangeavatar', 'adminchangeavatar');
        });

    // DEVICE INFO
    Route::post('adminsavedeviceinfo', [AdminfcmApiController::class, 'adminsavedeviceinfo']);

    // SUPPORT
    Route::post('adminsupport', [AdminsupportApiController::class, 'adminsupport']);

    // FAQ
    Route::post('adminfaq', [AdminfaqApiController::class, 'adminfaq']);

    // LOGOUT
    Route::get('adminlogout', [AdminlogoutApiController::class, 'adminlogout']);

    // NOTIFICATION
    Route::get('adminnotification', [AdminnotificationApiController::class, 'adminnotification']);

    // CUSTOMER
    Route::controller(AdmincustomerApiController::class)
        ->group(function () {
            Route::post('admincustomerlistandsearch', 'admincustomerlistandsearch');
            Route::post('admincreatecustomer', 'admincreatecustomer');
            Route::post('adminshowcustomer', 'adminshowcustomer');
        });

    // PRODUCT CATEGORY
    Route::post('adminsearchproductcategory', [AdminproductcategoryApiController::class, 'adminsearchproductcategory']);

    // PRODUCT
    Route::controller(AdminproductApiController::class)
        ->group(function () {
            Route::post('adminsearchproduct', 'adminsearchproduct');
            Route::post('adminoverallproductsearch', 'adminoverallproductsearch');
            Route::post('admincreateproduct', 'admincreateproduct');
        });

    // PLACE ORDER
    Route::controller(AdminplaceorderApiController::class)
        ->group(function () {
            Route::post('adminplaceorder', 'adminplaceorder');
            Route::post('adminholdorderlist', 'adminholdorderlist');
            Route::post('admingetholdorder', 'admingetholdorder');
            Route::post('admindeleteholdorder', 'admindeleteholdorder');
            Route::post('admindeleteholdorderitem', 'admindeleteholdorderitem');
            Route::post('admindeleteorderitem', 'admindeleteorderitem');
        });

    // ORDER HISTORY
    Route::controller(AdminorderhistoryApiController::class)
        ->group(function () {
            Route::post('individualhistory', 'individualhistory');
            Route::post('adminoverallorderhistory', 'adminoverallorderhistory');
            Route::post('showorderbyuuid', 'showorderbyuuid');
        });

    Route::get('admindashboard', [AdmindashboardApiController::class, 'admindashboard']);

    Route::get('adminpossetting', [AdminpossettingApiController::class, 'adminpossetting']);

    Route::post('admingetcustomerorder', [AdmingetcustomerorderApiController::class, 'admingetcustomerorder']);

    // UOM
    Route::get('admingetuomlist', [AdminuomApiController::class, 'admingetuomlist']);

    //EXPENSE CATEGORY
    Route::get('admingetexpensecategorylist', [AdminexpensecategoryApiController::class, 'admingetexpensecategorylist']);

    // SUPPLIER
    Route::controller(AdminsupplierApiController::class)
        ->group(function () {
            Route::post('admincreateoreditsupplier', 'admincreateoreditsupplier');
            Route::post('adminsupplierlist', 'adminsupplierlist');
            Route::post('adminshowsupplier', 'adminshowsupplier');
        });

    // EXPENSE
    Route::controller(AdminexpenseApiController::class)
        ->group(function () {
            Route::post('admincreateoreditexpense', 'admincreateoreditexpense');
            Route::post('adminexpenselist', 'adminexpenselist');
            Route::post('adminshowexpense', 'adminshowexpense');
        });

    // PURCHASE
    Route::controller(AdminpurchaseApiController::class)
        ->group(function () {
            Route::post('admincreateoreditpurchase', 'admincreateoreditpurchase');
            Route::post('adminpurchaselist', 'adminpurchaselist');
            Route::post('adminshowpurchase', 'adminshowpurchase');
        });

    // SALE RETURN
    Route::controller(AdminsalereturneApiController::class)
        ->group(function () {
            Route::post('admincreatesalereturn', 'admincreatesalereturn');
            Route::post('admingetsalereturnlist', 'admingetsalereturnlist');
            Route::post('admingetsalereturnbyuuid', 'admingetsalereturnbyuuid');
        });

    // PURCHASE RETURN
    Route::controller(AdminpurchasereturnApiController::class)
        ->group(function () {
            Route::post('admincreatepurchasereturn', 'admincreatepurchasereturn');
        });

});
