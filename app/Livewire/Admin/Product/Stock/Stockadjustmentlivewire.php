<?php

namespace App\Livewire\Admin\Product\Stock;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Product\Product;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Stockadjustmentlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $product;
    public $product_id;

    public $formdata = [
        'stockadjust' => 0,
    ];

    protected $listeners = ['formreset'];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function rules(): array
    {
        return [
            'form.stockadjust' => 'required|integer|min:1',
        ];
    }

    protected $messages = [
        'form.stockadjust.required' => 'Stock is required',
        'form.stockadjust.integer' => 'Stock must be a Number',
        'form.stockadjust.min' => 'Stock must be atleast One',
    ];

    protected function databind($productid, $type): void
    {
        $this->product = Product::find($productid);
    }

    public function addstock(Product $product): void
    {

        $this->validate();

        $product->stockcdable()
            ->create([
                'credit' => $this->form['stockadjust'],
                'debit' => 0,
                'is_adjustment' => true,
                'balance' => $product->stock + $this->form['stockadjust'],
                'c_or_d' => 'C',
                'product_id' => $product->id,
            ]);

        $product->stock = $product->stock + $this->form['stockadjust'];
        $product->save();
        $this->formreset();
        $this->dispatch('closemodal');
        Trackmessagehelper::trackmessage(auth()->user(), $product, 'addstock', session()->getId(), 'WEB', 'Stock Added');
        $this->toaster('success', 'Stock Added Successfully');
    }

    public function substock(Product $product): void
    {
        $this->validate();

        $product->stockcdable()
            ->create([
                'credit' => 0,
                'debit' => $this->form['stockadjust'],
                'is_adjustment' => false,
                'balance' => $product->stock - $this->form['stockadjust'],
                'c_or_d' => 'D',
                'product_id' => $product->id,
            ]);

        $product->stock = $product->stock - $this->form['stockadjust'];
        $product->save();
        $this->formreset();
        $this->dispatch('closemodal');
        Trackmessagehelper::trackmessage(auth()->user(), $product, 'substock', session()->getId(), 'WEB', 'Stock Reduced');
        $this->toaster('success', 'Stock Reduced Successfully');
    }

    #[Computed]
    public function stock()
    {
        return Product::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.product.stock.stockadjustmentlivewire');
    }
}
