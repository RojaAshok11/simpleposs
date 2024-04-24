<?php

namespace App\Providers;

use App\Repository\Admin\Api\Businesslogic\Auth\AdminlogoutApiRepository;
use App\Repository\Admin\Api\Businesslogic\Auth\AdminpasswordloginApiRepository;
use App\Repository\Admin\Api\Businesslogic\Customer\AdmincustomerApiRepository;
use App\Repository\Admin\Api\Businesslogic\Customer\AdmingetcustomerorderApiRepository;
use App\Repository\Admin\Api\Businesslogic\Dashboard\AdmindashboardApiRepository;
use App\Repository\Admin\Api\Businesslogic\Expense\AdminexpenseApiRepository;
use App\Repository\Admin\Api\Businesslogic\Faq\AdminfaqApiRepository;
use App\Repository\Admin\Api\Businesslogic\Fcm\AdminfcmApiRepository;
use App\Repository\Admin\Api\Businesslogic\Notification\AdminnotificationApiRepository;
use App\Repository\Admin\Api\Businesslogic\Order\AdminplaceorderApiRepository;
use App\Repository\Admin\Api\Businesslogic\Order\OrderhistoryApiRepository;
use App\Repository\Admin\Api\Businesslogic\Possetting\AdminpossettingApiRepository;
use App\Repository\Admin\Api\Businesslogic\Productcategory\AdminproductcategoryApiRepository;
use App\Repository\Admin\Api\Businesslogic\Product\AdminproductApiRepository;
use App\Repository\Admin\Api\Businesslogic\Profile\AdminprofileApiRepository;
use App\Repository\Admin\Api\Businesslogic\Purchasereturn\AdminpurchasereturnApiRepository;
use App\Repository\Admin\Api\Businesslogic\Purchase\AdminpurchaseApiRepository;
use App\Repository\Admin\Api\Businesslogic\Salesreturn\AdminsalesreturnApiRepository;
use App\Repository\Admin\Api\Businesslogic\Settings\Expensecategory\AdminexpensecategoryApiRepository;
use App\Repository\Admin\Api\Businesslogic\Settings\Uom\AdminuomApiRepository;
use App\Repository\Admin\Api\Businesslogic\Supplier\AdminsupplierApiRepository;
use App\Repository\Admin\Api\Businesslogic\Support\AdminsupportApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminlogoutApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminpasswordloginApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmincustomerApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmingetcustomerorderApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Dashboard\IAdmindashboardApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Expense\IAdminexpenseApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Faq\IAdminfaqApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Fcm\IAdminfcmApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Notification\IAdminnotificationApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Order\IAdminplaceorderApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Order\IOrderhistoryApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Possetting\IAdminpossettingApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Productcategory\IAdminproductcategoryApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Product\IAdminproductApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Profile\IAdminprofileApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Purchasereturn\IAdminpurchasereturnApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Purchase\IAdminpurchaseApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Salesreturn\IAdminsalesreturnApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Settings\Expensecategory\IAdminexpensecategoryApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Settings\Uom\IAdminuomApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Supplier\IAdminsupplierApiRepository;
use App\Repository\Admin\Api\Interfacelayer\Support\IAdminsupportApiRepository;
use Illuminate\Support\ServiceProvider;

class AdminApiRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        // LOGIN
        $this->app->bind(IAdminpasswordloginApiRepository::class, AdminpasswordloginApiRepository::class);

        //LOGOUT
        $this->app->bind(IAdminlogoutApiRepository::class, AdminlogoutApiRepository::class);

        //FAQ
        $this->app->bind(IAdminfaqApiRepository::class, AdminfaqApiRepository::class);

        //FCM
        $this->app->bind(IAdminfcmApiRepository::class, AdminfcmApiRepository::class);

        //NOTIFICATION
        $this->app->bind(IAdminnotificationApiRepository::class, AdminnotificationApiRepository::class);

        //PROFILE
        $this->app->bind(IAdminprofileApiRepository::class, AdminprofileApiRepository::class);

        //SUPPORT
        $this->app->bind(IAdminsupportApiRepository::class, AdminsupportApiRepository::class);

        //CUSTOMER
        $this->app->bind(IAdmincustomerApiRepository::class, AdmincustomerApiRepository::class);

        //PRODUCT CATEGORY
        $this->app->bind(IAdminproductcategoryApiRepository::class, AdminproductcategoryApiRepository::class);

        //PRODUCT
        $this->app->bind(IAdminproductApiRepository::class, AdminproductApiRepository::class);

        //ORDER HISTORY
        $this->app->bind(IOrderhistoryApiRepository::class, OrderhistoryApiRepository::class);

        //PLACE ORDER
        $this->app->bind(IAdminplaceorderApiRepository::class, AdminplaceorderApiRepository::class);

        //DASHBOARD
        $this->app->bind(IAdmindashboardApiRepository::class, AdmindashboardApiRepository::class);

        //POS SETTING
        $this->app->bind(IAdminpossettingApiRepository::class, AdminpossettingApiRepository::class);

        //CUSTOMER ORDER DETAILS
        $this->app->bind(IAdmingetcustomerorderApiRepository::class, AdmingetcustomerorderApiRepository::class);

        //UOM
        $this->app->bind(IAdminuomApiRepository::class, AdminuomApiRepository::class);

        //SUPPLIER
        $this->app->bind(IAdminsupplierApiRepository::class, AdminsupplierApiRepository::class);

        //EXPENSE CATEGORY
        $this->app->bind(IAdminexpensecategoryApiRepository::class, AdminexpensecategoryApiRepository::class);

        //EXPENSE
        $this->app->bind(IAdminexpenseApiRepository::class, AdminexpenseApiRepository::class);

        //PURCHASE
        $this->app->bind(IAdminpurchaseApiRepository::class, AdminpurchaseApiRepository::class);

        //SALE RETURN
        $this->app->bind(IAdminsalesreturnApiRepository::class, AdminsalesreturnApiRepository::class);

        //PURCHASE RETURN
        $this->app->bind(IAdminpurchasereturnApiRepository::class, AdminpurchasereturnApiRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
