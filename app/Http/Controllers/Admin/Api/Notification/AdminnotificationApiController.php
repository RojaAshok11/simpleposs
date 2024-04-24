<?php

namespace App\Http\Controllers\Admin\Api\Notification;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Notification\IAdminnotificationApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class AdminnotificationApiController extends BaseApiController
{

    public $adminnotificationapi;

    public function __construct(IAdminnotificationApiRepository $adminnotificationapi)
    {
        $this->adminnotificationapi = $adminnotificationapi;
    }

    public function adminnotification(Request $request)
    {
        try {
            return $this->callrepofuncion('adminnotificationapi', 'adminnotification', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminnotification', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminnotification', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminnotification', $e->getMessage(), false, 404);
        }
    }

}
