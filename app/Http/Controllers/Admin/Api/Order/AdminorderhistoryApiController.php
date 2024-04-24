<?php

namespace App\Http\Controllers\Admin\Api\Order;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Order\IOrderhistoryApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use PDOException;

class AdminorderhistoryApiController extends BaseApiController
{

    public $orderhistory;

    public function __construct(IOrderhistoryApiRepository $orderhistory)
    {
        $this->orderhistory = $orderhistory;
    }

    public function individualhistory()
    {
        try {
            return $this->callrepofuncion('orderhistory', 'individualhistory', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'individualhistory', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'individualhistory', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'individualhistory', $e->getMessage(), false, 404);
        }
    }

    public function adminoverallorderhistory()
    {
        try {
            return $this->callrepofuncion('orderhistory', 'adminoverallorderhistory', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminoverallorderhistory', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminoverallorderhistory', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminoverallorderhistory', $e->getMessage(), false, 404);
        }
    }

    public function showorderbyuuid(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('orderhistory', 'showorderbyuuid', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'showorderbyuuid', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'showorderbyuuid', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'showorderbyuuid', $e->getMessage(), false, 404);
        }
    }

}
