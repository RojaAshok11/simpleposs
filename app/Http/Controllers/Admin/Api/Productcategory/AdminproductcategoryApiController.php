<?php

namespace App\Http\Controllers\Admin\Api\Productcategory;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\SearchRequest;
use App\Repository\Admin\Api\Interfacelayer\Productcategory\IAdminproductcategoryApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminproductcategoryApiController extends BaseApiController
{

    public $adminproductcategoryapi;

    public function __construct(IAdminproductcategoryApiRepository $adminproductcategoryapi)
    {
        $this->adminproductcategoryapi = $adminproductcategoryapi;
    }

    public function adminsearchproductcategory(SearchRequest $request)
    {
        try {
            return $this->callrepofuncion('adminproductcategoryapi', 'adminsearchproductcategory', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsearchproductcategory', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsearchproductcategory', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsearchproductcategory', $e->getMessage(), false, 404);
        }
    }

}
