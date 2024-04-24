<?php

namespace App\Http\Controllers\Admin\Api\Customer;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Customer\AdmincreatecustomerApiRequest;
use App\Http\Requests\Commonvalidation\Api\Common\SearchRequest;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmincustomerApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdmincustomerApiController extends BaseApiController
{

    public $admincustomerapi;

    public function __construct(IAdmincustomerApiRepository $admincustomerapi)
    {
        $this->admincustomerapi = $admincustomerapi;
    }

    public function admincustomerlistandsearch(SearchRequest $request)
    {
        try {
            return $this->callrepofuncion('admincustomerapi', 'admincustomerlistandsearch', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincustomerlistandsearch', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincustomerlistandsearch', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincustomerlistandsearch', $e->getMessage(), false, 404);
        }
    }

    public function admincreatecustomer(AdmincreatecustomerApiRequest $request)
    {
        try {
            return $this->callrepofuncion('admincustomerapi', 'admincreatecustomer', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreatecustomer', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreatecustomer', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreatecustomer', $e->getMessage(), true, 404);
        }
    }

    public function adminshowcustomer(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('admincustomerapi', 'adminshowcustomer', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminshowcustomer', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminshowcustomer', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminshowcustomer', $e->getMessage(), true, 404);
        }
    }

}
