<?php

namespace App\Http\Controllers\Admin\Api\Profile;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Profile\AdminchangeavatarApiRequest;
use App\Http\Requests\Admin\Api\Profile\AdminchangepasswordApiRequest;
use App\Http\Requests\Admin\Api\Profile\AdminupdateprofileApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Profile\IAdminprofileApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use Validator;

class AdminpofileApiController extends BaseApiController
{

    public $adminprofileapi;

    public function __construct(IAdminprofileApiRepository $adminprofileapi)
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        $this->adminprofileapi = $adminprofileapi;
    }

    public function admingetprofile(Request $request)
    {
        try {
            return $this->callrepofuncion('adminprofileapi', 'admingetprofile', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admingetprofile', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admingetprofile', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admingetprofile', $e->getMessage(), false, 404);
        }
    }

    public function adminupdateprofile(AdminupdateprofileApiRequest $request)
    {
        try {

            return $this->callrepofuncion('adminprofileapi', 'adminupdateprofile', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminupdateprofile', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminupdateprofile', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminupdateprofile', $e->getMessage(), true, 404);
        }
    }

    public function adminchangepassword(AdminchangepasswordApiRequest $request)
    {
        try {

            return $this->callrepofuncion('adminprofileapi', 'adminchangepassword', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminchangepassword', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminchangepassword', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminchangepassword', $e->getMessage(), true, 404);
        }
    }

    public function adminchangeavatar(AdminchangeavatarApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminprofileapi', 'adminchangeavatar', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminchangeavatar', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminchangeavatar', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminchangeavatar', $e->getMessage(), true, 404);
        }
    }

}
