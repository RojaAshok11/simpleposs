<?php

namespace App\Http\Controllers\Admin\Api\Order;

use App\Http\Controllers\Helper\BaseApiController;
use App\Http\Requests\Commonvalidation\Api\Common\UuidApiRequest;
use App\Repository\Admin\Api\Interfacelayer\Order\IAdminplaceorderApiRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Validator;

class AdminplaceorderApiController extends BaseApiController
{

    public $placeorder;

    public function __construct(IAdminplaceorderApiRepository $placeorder)
    {
        $this->placeorder = $placeorder;
    }

    public function adminplaceorder(Request $request)
    {
        try {
            $requestdata = collect(json_decode(request()->salesdetails, true))->toArray();
            Log::info('Request Sales');
            Log::info(json_encode($requestdata));
            Log::info('----------------------------------------------------------------');
            $reference_id = App::make('possetting')->is_hold && App::make('possetting')->is_holdreference ? true : false;
            $tax_type = App::make('possetting')->tax_type;
            $validator = Validator::make($requestdata, [

                'is_hold' => 'bail|nullable|boolean',
                'reference_id' => $reference_id ? 'bail|required_if:is_hold,true|nullable|boolean' : 'bail|nullable|boolean',
                'sales_uuid' => 'bail|nullable|max:50',
                'customer_uuid' => 'bail|nullable|max:50',
                "customer_name" => "bail|nullable|min:3|max:50",
                "customer_phone" => "bail|nullable|digits:10",
                'sub_total' => 'bail|required_if:is_hold,false|nullable',
                'discount' => 'bail|nullable',
                'extra_charges' => 'bail|nullable',
                'received_amount' => 'bail|required_if:is_hold,false',
                'remaining_amount' => 'bail|nullable',
                'total' => 'bail|required_if:is_hold,false|nullable',
                'roundoff' => 'bail|nullable',
                'grandtotal' => 'bail|required_if:is_hold,false|nullable',
                'mode' => 'bail|required_if:is_hold,false|min:1|max:3|nullable',
                'source_type' => 'bail|required|integer|min:1|max:5',
                'salesitem' => 'bail|required|array',

                'salesitem.*.saleitem_uuid' => 'bail|nullable|max:50',
                'salesitem.*.product_uuid' => 'bail|required|max:50',
                'salesitem.*.price' => 'bail|required_if:is_hold,false|nullable',
                'salesitem.*.quantity' => 'bail|required',
                'salesitem.*.total' => 'bail|required_if:is_hold,false|nullable',
            ], [
                'salesitem.required' => 'Select a product',
                'mode.min' => 'Invalid Payment Method',
                'mode.max' => 'Invalid Payment Method',
                'salesitem.*.product_uuid.required' => 'Product uuid required',
                'salesitem.*.quantity.required' => 'Enter a quantity',
                'salesitem.*.price.required_if' => 'Enter a price',
                'salesitem.*.total.required_if' => 'Enter a total',
                'salesitem.*.total.required_if' => 'Enter a total',
            ]);

            if ($validator->fails()) {
                DB::rollback();
                return response()->error([false, $validator->errors()->first()], 404);
            }
            return $this->callrepofuncion('placeorder', 'adminplaceorder', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminplaceorder', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminplaceorder', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminplaceorder', $e->getMessage(), true, 404);
        }
    }

    public function adminholdorderlist()
    {
        try {
            return $this->callrepofuncion('placeorder', 'adminholdorderlist', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'adminholdorderlist', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'adminholdorderlist', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'adminholdorderlist', $e->getMessage(), false, 404);
        }
    }

    public function admingetholdorder(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('placeorder', 'admingetholdorder', null, false);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admingetholdorder', $e->getMessage(), false, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admingetholdorder', $e->getMessage(), false, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admingetholdorder', $e->getMessage(), false, 404);
        }
    }

    public function admindeleteholdorder(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('placeorder', 'admindeleteholdorder', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admindeleteholdorder', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admindeleteholdorder', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admindeleteholdorder', $e->getMessage(), true, 404);
        }
    }

    public function admindeleteholdorderitem(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('placeorder', 'admindeleteholdorderitem', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admindeleteholdorderitem', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admindeleteholdorderitem', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admindeleteholdorderitem', $e->getMessage(), true, 404);
        }
    }

    public function admindeleteorderitem(UuidApiRequest $request)
    {
        try {
            return $this->callrepofuncion('placeorder', 'admindeleteorderitem', null, true);

        } catch (Exception $e) {
            return $this->exceptionone(null, 'admindeleteorderitem', $e->getMessage(), true, 404);
        } catch (QueryException $e) {
            return $this->exceptiontwo(null, 'admindeleteorderitem', $e->getMessage(), true, 404);
        } catch (PDOException $e) {
            return $this->exceptionthree(null, 'admindeleteorderitem', $e->getMessage(), true, 404);
        }
    }

}
