<?php

namespace App\Http\Controllers\Admin\Api\Purchase;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\SearchRequest;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Purchase\IAdminpurchaseApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Validator;

class AdminpurchaseApiController extends BaseApiController
{

    public $adminpurchaseapi;

    public function __construct(IAdminpurchaseApiRepository $adminpurchaseapi)
    {
        $this->adminpurchaseapi = $adminpurchaseapi;
    }

    public function admincreateoreditpurchase(Request $request)
    {
        try {
            $requestdata = collect(json_decode(request()->purchasedetails, true))->toArray();
            Log::info('Request Sales');
            Log::info(json_encode($requestdata));
            Log::info('----------------------------------------------------------------');
            $validator = Validator::make($requestdata, [

                'purchase_uuid' => 'bail|nullable|max:50',
                'supplier_uuid' => 'bail|required|max:50',
                'purchase_date' => 'bail|required|date',
                'sub_total' => 'bail|required',
                'freight_charges' => 'bail|nullable',
                'adjustment' => 'bail|nullable',
                'discount' => 'bail|nullable',
                'total' => 'bail|required',
                'roundoff' => 'bail|nullable',
                'grandtotal' => 'bail|required',
                'note' => 'bail|nullable|min:3|max:255',
                'source_type' => 'bail|required|integer|min:1|max:5',

                'purchaseitem.*.purchase_uuid' => 'bail|nullable|max:50',
                'purchaseitem.*.product_uuid' => 'bail|required|max:50',
                'purchaseitem.*.price' => 'bail|required',
                'purchaseitem.*.quantity' => 'bail|required',
                'purchaseitem.*.total' => 'bail|required',
            ]);

            if ($validator->fails()) {
                DB::rollback();
                return response()->error([false, $validator->errors()], 404);
            }
            return $this->callrepofuncion('adminpurchaseapi', 'admincreateoreditpurchase', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreateoreditpurchase', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreateoreditpurchase', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreateoreditpurchase', $e->getMessage(), true, 404);
        }
    }

    public function adminpurchaselist(SearchRequest $request)
    {
        try {
            return $this->callrepofuncion('adminpurchaseapi', 'adminpurchaselist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminpurchaselist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminpurchaselist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminpurchaselist', $e->getMessage(), false, 404);
        }
    }

    public function adminshowpurchase(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('adminpurchaseapi', 'adminshowpurchase', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminshowpurchase', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminshowpurchase', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminshowpurchase', $e->getMessage(), false, 404);
        }
    }

}
