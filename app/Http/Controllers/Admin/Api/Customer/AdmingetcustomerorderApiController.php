<?php

namespace App\Http\Controllers\Admin\Api\Customer;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Customer\IAdmingetcustomerorderApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdmingetcustomerorderApiController extends BaseApiController
{

    public $admincustomerorderapi;

    public function __construct(IAdmingetcustomerorderApiRepository $admincustomerorderapi)
    {
        $this->admincustomerorderapi = $admincustomerorderapi;
    }

    public function admingetcustomerorder(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('admincustomerorderapi', 'admingetcustomerorder', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admingetcustomerorder', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admingetcustomerorder', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admingetcustomerorder', $e->getMessage(), false, 404);
        }
    }

}
