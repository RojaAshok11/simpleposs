<?php

namespace App\Http\Controllers\Admin\Api\Auth;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Auth\AdminpasswordloginApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminpasswordloginApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminpasswordloginApiController extends BaseApiController
{

    public $adminpasswordloginapi;

    public function __construct(IAdminpasswordloginApiRepository $adminpasswordloginapi)
    {
        $this->adminpasswordloginapi = $adminpasswordloginapi;
    }
    public function adminpasswordlogin(AdminpasswordloginApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminpasswordloginapi', 'adminpasswordlogin', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminpasswordlogin', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminpasswordlogin', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminpasswordlogin', $e->getMessage(), false, 404);
        }
    }

}
