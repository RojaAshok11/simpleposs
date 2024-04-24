<?php

namespace App\Http\Controllers\Admin\Api\Auth;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminlogoutApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class AdminlogoutApiController extends BaseApiController
{

    public $adminlogoutapi;

    public function __construct(IAdminlogoutApiRepository $adminlogoutapi)
    {
        $this->adminlogoutapi = $adminlogoutapi;
    }

    public function adminlogout(Request $request)
    {
        try {
            return $this->callrepofuncion('adminlogoutapi', 'adminlogout', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminlogout', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminlogout', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminlogout', $e->getMessage(), false, 404);
        }
    }

}
