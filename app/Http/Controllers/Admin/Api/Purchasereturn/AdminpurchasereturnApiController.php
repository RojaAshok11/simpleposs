<?php

namespace App\Http\Controllers\Admin\Api\Purchasereturn;

use App\Http\Controllers\Helper\BaseApiController;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Repository\Admin\Api\Interfacelayer\Purchasereturn\IAdminpurchasereturnApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Validator;

class AdminpurchasereturnApiController extends BaseApiController
{

    public $purchasereturn;

    public function __construct(IAdminpurchasereturnApiRepository $purchasereturn)
    {
        $this->purchasereturn = $purchasereturn;
    }

    public function admincreatepurchasereturn(Request $request)
    {
        try {
            $requestdata = collect(json_decode(request()->purchasereturndetails, true))->toArray();
            Log::info('Request Purchase');
            Log::info(json_encode($requestdata));

            Log::info('----------------------------------------------------------------');
            foreach ($requestdata['purchasereturnitem'] as $key => $value) {
                $purchaseitem = Purchaseitem::where('uuid', $value['purchaseitem_uuid'])->first();
                $requestdata['purchasereturnitem'][$key]['quantity'] = $purchaseitem->quantity;
                $requestdata['purchasereturnitem'][$key]['returnable_quantity'] = $purchaseitem->returnable_quantity;
            }
            $validator = Validator::make($requestdata, [

                'purchase_uuid' => 'bail|required|max:50',
                'supplier_uuid' => 'bail|required|max:50',
                "return_note" => "bail|required|min:3|max:255",
                'total' => 'bail|required',
                'roundoff' => 'bail|nullable',
                'grandtotal' => 'bail|required',
                'source_type' => 'bail|required|integer|min:1|max:5',

                'purchasereturnitem.*.purchaseitem_uuid' => 'bail|required|max:50',
                'purchasereturnitem.*.product_uuid' => 'bail|required|max:50',
                'purchasereturnitem.*.total' => 'bail|required',
                'purchasereturnitem.*.return_quantity' => 'bail|required|lte:purchasereturnitem.*.returnable_quantity|lte:purchasereturnitem.*.quantity|gt:0',
            ], [
                'purchasereturnitem.*.return_quantity.required' => 'Enter Quantity',
                'purchasereturnitem.*.return_quantity.lte' => 'Return Quantity Exceeds',
                'purchasereturnitem.*.return_quantity.gt' => 'Invalid Quantity',
            ]);

            if ($validator->fails()) {
                DB::rollback();
                return response()->error([false, $validator->errors()], 404);
            }
            return $this->callrepofuncion('purchasereturn', 'admincreatepurchasereturn', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admincreatepurchasereturn', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admincreatepurchasereturn', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admincreatepurchasereturn', $e->getMessage(), true, 404);
        }
    }

}
