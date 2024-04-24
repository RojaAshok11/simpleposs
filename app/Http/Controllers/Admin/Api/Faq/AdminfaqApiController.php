<?php

namespace App\Http\Controllers\Admin\Api\Faq;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\FaqRequest;
use App\Repository\Admin\Api\Interfacelayer\Faq\IAdminfaqApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminfaqApiController extends BaseApiController
{

    public $adminfaqapi;

    public function __construct(IAdminfaqApiRepository $adminfaqapi)
    {
        $this->adminfaqapi = $adminfaqapi;
    }

    public function adminfaq(FaqRequest $request)
    {
        try {
            return $this->callrepofuncion('adminfaqapi', 'adminfaq', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminfaq', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminfaq', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminfaq', $e->getMessage(), false, 404);
        }
    }

}
