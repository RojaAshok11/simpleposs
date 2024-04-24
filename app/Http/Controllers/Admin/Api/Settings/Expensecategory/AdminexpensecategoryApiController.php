<?php

namespace App\Http\Controllers\Admin\Api\Settings\Expensecategory;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Settings\Expensecategory\IAdminexpensecategoryApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminexpensecategoryApiController extends BaseApiController
{

    public $adminexpensecategoryapi;

    public function __construct(IAdminexpensecategoryApiRepository $adminexpensecategoryapi)
    {
        $this->adminexpensecategoryapi = $adminexpensecategoryapi;
    }

    public function admingetexpensecategorylist()
    {
        try {
            return $this->callrepofuncion('adminexpensecategoryapi', 'admingetexpensecategorylist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admingetexpensecategorylist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admingetexpensecategorylist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admingetexpensecategorylist', $e->getMessage(), false, 404);
        }
    }

}
