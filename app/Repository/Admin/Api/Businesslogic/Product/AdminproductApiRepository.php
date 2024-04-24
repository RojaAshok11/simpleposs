<?php

namespace App\Repository\Admin\Api\Businesslogic\Product;

use App\Http\Resources\Admin\Product\Productsearch\ProductsearchCollection;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Settings\Mastersettings\Productcategory;
use App\Models\Admin\Settings\Mastersettings\Uom;
use App\Repository\Admin\Api\Interfacelayer\Product\IAdminproductApiRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AdminproductApiRepository implements IAdminproductApiRepository
{
    public function adminsearchproduct()
    {
        return [true,
            new ProductsearchCollection(Product::query()
                    ->where(fn($q) =>
                        $q->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('name', 'like', '%' . request('search') . '%')
                    )
                    ->when(request('productcategory_uuid'), fn($q1) =>
                        $q1->whereHas('productcategory', fn(Builder $q) => $q->where('uuid', request('productcategory_uuid'))))
                    ->active()
                    ->latest()
                    ->paginate(15)),
            'Product List'];
    }

    public function adminoverallproductsearch()
    {
        return [true,

            new ProductsearchCollection(Product::query()
                    ->where(fn($q) =>
                        $q->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('name', 'like', '%' . request('search') . '%')
                            ->orWhereHas('productcategory', fn($q) => $q->where('name', 'like', '%' . request('search') . '%')))
                    ->when(request('productcategory_uuid'), fn($q1) =>
                        $q1->whereHas('productcategory', fn(Builder $q) => $q->where('uuid', request('productcategory_uuid'))))
                    ->active()
                    ->latest()
                    ->paginate(15)),
            'Overall Product List'];
    }

    public function admincreateproduct()
    {
        $product = Product::where('uuid', request()->uuid)->first();

        if (request()->hasFile('image')) {
            if ($product) {
                $product->image ? Storage::delete('public/' . $product->image) : '';
            }

        }
        Product::updateorCreate(
            [
                'uuid' => request()->uuid,
            ],
            ['name' => request()->name,
                'productcategory_id' => Productcategory::where('uuid', request()->productcategory_uuid)->first()?->id,
                'purchaseprice' => request()->purchaseprice,
                'sellingprice' => request()->sellingprice,
                'sku' => request()->sku,
                'image' => request()->hasFile('image') ? request('image')->store('image', 'public') : ($product ? $product->image : null),
                'uom_id' => Uom::where('uuid', request()->uom_uuid)->first()?->id,
                'note' => request()->note,
                'active' => request()->active,
                'cgst' => request()->cgst,
                'sgst' => request()->sgst,
                'igst' => request()->igst,
                'cess' => request()->cess,
                'hsncode' => request()->hsncode,
                'is_nonveg' => request()->is_nonveg]
        );
        return [true, null, 'Product Created Successfully'];
    }
}
