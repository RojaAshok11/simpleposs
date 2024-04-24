<?php

namespace App\Http\Controllers\Admin\Api\Settings\Uom;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Settings\Uom\IAdminuomApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminuomApiController extends BaseApiController
{

    public $adminuomapi;

    public function __construct(IAdminuomApiRepository $adminuomapi)
    {
        $this->adminuomapi = $adminuomapi;
    }

    public function admingetuomlist()
    {
        try {
            return $this->callrepofuncion('adminuomapi', 'admingetuomlist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admingetuomlist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admingetuomlist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admingetuomlist', $e->getMessage(), false, 404);
        }
    }

}
