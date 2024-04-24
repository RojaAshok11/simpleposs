<?php

namespace App\Http\Controllers\Admin\Api\Supplier;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Supplier\AdminsuppliercreateApiRequest;
use App\Http\Requests\Commonvalidation\Api\Common\SearchRequest;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Supplier\IAdminsupplierApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminsupplierApiController extends BaseApiController
{

    public $adminsupplierapi;

    public function __construct(IAdminsupplierApiRepository $adminsupplierapi)
    {
        $this->adminsupplierapi = $adminsupplierapi;
    }

    public function admincreateoreditsupplier(AdminsuppliercreateApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminsupplierapi', 'admincreateoreditsupplier', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreateoreditsupplier', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreateoreditsupplier', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreateoreditsupplier', $e->getMessage(), true, 404);
        }
    }

    public function adminsupplierlist(SearchRequest $request)
    {
        try {
            return $this->callrepofuncion('adminsupplierapi', 'adminsupplierlist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsupplierlist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsupplierlist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsupplierlist', $e->getMessage(), false, 404);
        }
    }

    public function adminshowsupplier(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminsupplierapi', 'adminshowsupplier', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminshowsupplier', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminshowsupplier', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminshowsupplier', $e->getMessage(), false, 404);
        }
    }

}
