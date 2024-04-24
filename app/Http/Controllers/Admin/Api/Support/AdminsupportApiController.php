<?php

namespace App\Http\Controllers\Admin\Api\Support;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\SupportRequest;
use App\Repository\Admin\Api\Interfacelayer\Support\IAdminsupportApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminsupportApiController extends BaseApiController
{

    public $adminsupportapi;

    public function __construct(IAdminsupportApiRepository $adminsupportapi)
    {
        $this->adminsupportapi = $adminsupportapi;
    }

    public function adminsupport(SupportRequest $request)
    {
        try {
            return $this->callrepofuncion('adminsupportapi', 'adminsupport', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsupport', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsupport', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsupport', $e->getMessage(), false, 404);
        }
    }

}
