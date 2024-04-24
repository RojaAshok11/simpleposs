<?php

namespace App\Http\Controllers\Admin\Api\Possetting;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Possetting\IAdminpossettingApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminpossettingApiController extends BaseApiController
{

    public $possetting;

    public function __construct(IAdminpossettingApiRepository $possetting)
    {
        $this->possetting = $possetting;
    }

    public function adminpossetting()
    {
        try {
            return $this->callrepofuncion('possetting', 'adminpossetting', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminpossetting', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminpossetting', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminpossetting', $e->getMessage(), true, 404);
        }
    }

}
