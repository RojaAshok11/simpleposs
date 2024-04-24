<?php

namespace App\Http\Controllers\Admin\Api\Dashboard;

use App\Http\Controllers\Helper\BaseApiController;
use App\Repository\Admin\Api\Interfacelayer\Dashboard\IAdmindashboardApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdmindashboardApiController extends BaseApiController
{

    public $dashboard;

    public function __construct(IAdmindashboardApiRepository $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function admindashboard()
    {
        try {
            return $this->callrepofuncion('dashboard', 'admindashboard', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admindashboard', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admindashboard', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admindashboard', $e->getMessage(), false, 404);
        }
    }
}
