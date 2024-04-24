<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller as Controller;
use DB;
use Log;

class BaseApiController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function callrepofuncion($reponame, $functionname, $argument, $isdbcommit)
    {
        if ($isdbcommit) {
            DB::beginTransaction();
        }

        $data = isset($argument) ? $this->$reponame->$functionname($argument) : $this->$reponame->$functionname();

        if ($data[0] && $isdbcommit) {
            DB::commit();
        }

        return ($data[0]) ? response()->success($data, 200) : response()->error($data, 404);
    }

    public function exceptionone($sessionid, $msg, $err, $isdbcommit, $status_code = 404)
    {
        return $this->exceptionhandler($sessionid, $msg, $err, $isdbcommit, $status_code, 'Exception One: ');
    }

    public function exceptiontwo($sessionid, $msg, $err, $isdbcommit, $status_code = 404)
    {
        return $this->exceptionhandler($sessionid, $msg, $err, $isdbcommit, $status_code, 'Exception Two: ');
    }

    public function exceptionthree($sessionid, $msg, $err, $isdbcommit, $status_code = 404)
    {
        return $this->exceptionhandler($sessionid, $msg, $err, $isdbcommit, $status_code, 'Exception Three: ');
    }

    public function exceptionfour($sessionid, $msg, $err, $isdbcommit, $status_code = 404)
    {
        return $this->exceptionhandler($sessionid, $msg, $err, $isdbcommit, $status_code, 'Exception Four: ');
    }

    private function exceptionhandler($sessionid, $msg, $err, $isdbcommit, $status_code, $exception)
    {
        if ($isdbcommit) {
            DB::rollback();
        }
        Log::error($exception . $msg . ' - loginsessionid : ' . $sessionid = isset($sessionid) ? $sessionid : response()->apisessionid() . ' Error : ' . $err);
        return response()->error([false, $exception . $err], $status_code);
    }

}
