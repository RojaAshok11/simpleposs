<?php

namespace App\Http\Controllers\Admin\Api\Expense;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Expense\AdminexpensecreateApiRequest;
use App\Http\Requests\Commonvalidation\Api\Common\SearchRequest;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Expense\IAdminexpenseApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminexpenseApiController extends BaseApiController
{

    public $adminexpenseapi;

    public function __construct(IAdminexpenseApiRepository $adminexpenseapi)
    {
        $this->adminexpenseapi = $adminexpenseapi;
    }

    public function admincreateoreditexpense(AdminexpensecreateApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminexpenseapi', 'admincreateoreditexpense', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreateoreditexpense', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreateoreditexpense', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreateoreditexpense', $e->getMessage(), true, 404);
        }
    }

    public function adminexpenselist(SearchRequest $request)
    {
        try {
            return $this->callrepofuncion('adminexpenseapi', 'adminexpenselist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminexpenselist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminexpenselist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminexpenselist', $e->getMessage(), false, 404);
        }
    }

    public function adminshowexpense(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminexpenseapi', 'adminshowexpense', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminshowexpense', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminshowexpense', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminshowexpense', $e->getMessage(), false, 404);
        }
    }

}
