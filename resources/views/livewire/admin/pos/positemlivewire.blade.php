<div class="row g-3 justify-content-between mb-2">
    <div class="col-md-6">
        <select wire:model.live="productcategory_id" class="form-select form-select-sm">
            <option value="0">Select a Category</option>
            @foreach ($this->productcategory as $key => $value)
                <option value={{ $key }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <div class="col input-group input-group-sm">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input wire:model.live="searchTerm" type="search" class="form-control" placeholder="Search Product"
                autofocus>
        </div>
        @error('productlist')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

@if (App::make('possetting')->theme == 1)
    <!-- 4 GRID DESIGN for POS items -->
    <div class="row g-1">
        @foreach ($this->product as $value => $item)
            <div class="col-6 col-md-3">
                <div class="card shadow-sm">
                    <div role="button" class="card-body px-0 pt-0 pb-0"
                        wire:click="onclickproduct('{{ $item->id }}')">

                        @if ($item->image)
                            <div class="text-center">
                                <img src="{{ url('storage/' . $item->image) }}" class="card-img-top img-fluid"
                                    style="height:45px;width:68px;" alt="...">
                            </div>
                        @else
                            <div class="text-center">
                                @if (App::make('possetting')->carticon)
                                    <img src="{{ url('storage/' . App::make('possetting')->carticon) }}"
                                        class="card-img-top img-fluid" style="height:45px;width:68px;" alt="...">
                                @else
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width:40%;object-fit: cover;">
                                        <i class="bi bi-cart fs-2"></i>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="card-body p-0">
                            <div class="text-center d-none d-md-block">
                                <div class="fw-bold" style="font-size: 70%;">{{ strtoupper($item->name) }}</div>
                            </div>
                            <div class="text-center d-block d-md-none">
                                <div class="fw-bold" style="font-size: 70%;">{{ strtoupper($item->name) }}</div>
                            </div>
                        </div>
                        <div class="card-footer text-white p-0 px-1"
                            style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};">
                            <div class="row justify-content-between align-items-center p-0 px-1">
                                <div class="col-5">
                                    <div class="fw-bold" style="font-size:90%;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ $item->sellingprice }}
                                    </div>
                                </div>
                                <div class="col-7 fw-bold text-end">
                                    <div style="font-size:62%;">
                                        {{ strtoupper($item->sku) }}
                                    </div>
                                </div>
                                <div class="col-5">
                                    @if ($item->is_nonveg)
                                        <img src="/images/nonveg.png" style="width:13%" alt="">
                                    @else
                                        <img src="/images/veg.png" style="width:13%" alt="">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <div class="fw-bold" style="font-size:62%;">
                                            <span>STOCK</span> - ({{ $item->stock }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End -->
@elseif(App::make('possetting')->theme == 2)
    <!-- 5 GRID DESIGN for POS items -->
    <div class="row gap-2">
        @foreach ($this->product as $value => $item)
            <div class="col-6 col-md-2 mx-auto px-1">
                <div class="card shadow-sm">
                    <div role="button" class="card-body px-0 pt-0 pb-0"
                        wire:click="onclickproduct('{{ $item->id }}')">

                        @if ($item->image)
                            <div class="text-center">
                                <img src="{{ url('storage/' . $item->image) }}" class="card-img-top img-fluid"
                                    style="height:40px;width:60px;" alt="...">
                            </div>
                        @else
                            <div class="text-center">
                                @if (App::make('possetting')->carticon)
                                    <img src="{{ url('storage/' . App::make('possetting')->carticon) }}"
                                        class="card-img-top img-fluid" style="height:40px;width:60px;" alt="...">
                                @else
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width:40%;object-fit: cover;">
                                        <i class="bi bi-cart fs-2"></i>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="card-body p-0">
                            <div class="text-center">
                                <div class="fw-bold" style="font-size: 65%;">{{ strtoupper($item->name) }}</div>
                            </div>
                        </div>
                        <div class="card-footer text-white p-0 px-1"
                            style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};">
                            <div class="row justify-content-between align-items-center p-0">
                                <div class="col-5">
                                    <div class="fw-bold" style="font-size:90%;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ $item->sellingprice }}
                                    </div>
                                </div>
                                <div class="col-7 fw-bold">
                                    <div style="font-size:60%;">
                                        {{ strtoupper($item->sku) }}
                                    </div>
                                </div>
                                <div class="col-5">
                                    @if ($item->is_nonveg)
                                        <img src="/images/nonveg.png" style="width:20%" alt="">
                                    @else
                                        <img src="/images/veg.png" style="width:20%" alt="">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <div class="">
                                        <div class="fw-bold" style="font-size:60%;">
                                            <span>STOCK</span> - ({{ $item->stock }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- End -->
@elseif(App::make('possetting')->theme == 3)
    <!-- 6 GRID DESIGN for POS items -->
    <div class="row g-1">
        @foreach ($this->product as $value => $item)
            <div class="col-6 col-md-2">
                <div class="card shadow-sm">
                    <div role="button" class="card-body px-0 pt-0 pb-0"
                        wire:click="onclickproduct('{{ $item->id }}')">

                        @if ($item->image)
                            <div class="text-center">
                                <img src="{{ url('storage/' . $item->image) }}" class="card-img-top img-fluid"
                                    style="height:45px;width:65px;" alt="...">
                            </div>
                        @else
                            <div class="text-center">
                                @if (App::make('possetting')->carticon)
                                    <img src="{{ url('storage/' . App::make('possetting')->carticon) }}"
                                        class="card-img-top img-fluid" style="height:45px;width:65px;"
                                        alt="...">
                                @else
                                    <div class="text-center">
                                        <i class="bi bi-cart fs-3"></i>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="card-body p-0">
                            <div class="text-center">
                                <div class="fw-bold" style="font-size: 65%;">{{ strtoupper($item->name) }}</div>
                            </div>
                        </div>
                        <div class="card-footer text-white p-0 m-0 px-1"
                            style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-5">
                                    <div class="fw-bold pr-1" style="font-size:95%;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ $item->sellingprice }}
                                    </div>
                                </div>
                                <div class="col-7 fw-bold">
                                    <div style="font-size:62%;">
                                        {{ strtoupper($item->sku) }}
                                    </div>
                                </div>
                                <div class="col-5">
                                    @if ($item->is_nonveg)
                                        <img src="/images/nonveg.png" style="width:20%" alt="">
                                    @else
                                        <img src="/images/veg.png" style="width:20%" alt="">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <div class="">
                                        <div class="fw-bold" style="font-size:62%;">
                                            <span>STOCK</span> - ({{ $item->stock }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End -->
@endif

<div class="d-flex justify-content-between mt-1" style="font-size:90%">
    <div class="m-2 p-1">
        Showing {{ $this->product->firstItem() }} to {{ $this->product->lastItem() }} out of
        {{ $this->product->total() }} items
    </div>
    <div class="ms-auto p-1 bd-highlight" style="font-size:70%">
        {{ $this->product->links() }}
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $("input[type=number]").on("focus", function() {
                $(this).on("keydown", function(event) {
                    if (event.keyCode === 38 || event.keyCode === 40) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush
