<?php

namespace App\Http\Controllers\Admin\Api\Fcm;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Admin\Api\Fcm\FcmRequest;
use App\Repository\Admin\Api\Interfacelayer\Fcm\IAdminfcmApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminfcmApiController extends BaseApiController
{

    public $adminfcmapi;

    public function __construct(IAdminfcmApiRepository $adminfcmapi)
    {
        $this->adminfcmapi = $adminfcmapi;
    }

    public function adminsavedeviceinfo(FcmRequest $request)
    {
        try {
            return $this->callrepofuncion('adminfcmapi', 'adminsavedeviceinfo', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminsavedeviceinfo', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminsavedeviceinfo', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminsavedeviceinfo', $e->getMessage(), true, 404);
        }
    }

}
