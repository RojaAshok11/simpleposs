<?php

namespace App\Http\Controllers\Admin\Api\Product;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Product\AdmincreateproductApiRequest;
use App\Http\Requests\Admin\Api\Product\ProductRequest;
use App\Repository\Admin\Api\Interfacelayer\Product\IAdminproductApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminproductApiController extends BaseApiController
{

    public $adminproductapi;

    public function __construct(IAdminproductApiRepository $adminproductapi)
    {
        $this->adminproductapi = $adminproductapi;
    }

    public function adminsearchproduct(ProductRequest $request)
    {
        Log::info("message". $request);
        try {

            return $this->callrepofuncion('adminproductapi', 'adminsearchproduct', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        }
    }

    public function adminoverallproductsearch(ProductRequest $request)
    {
        try {
            return $this->callrepofuncion('adminproductapi', 'adminoverallproductsearch', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsearchproduct', $e->getMessage(), false, 404);
        }
    }

    public function admincreateproduct(AdmincreateproductApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminproductapi', 'admincreateproduct', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreateproduct', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreateproduct', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreateproduct', $e->getMessage(), true, 404);
        }
    }

}
