<div>

    <form wire:submit.prevent="storesale" onkeydown="return event.key != 'Enter';" enctype="multipart/form-data"
        autocomplete="off">

        <div class="card bg-white">

            {{-- Header --}}

            <div class="card-header text-white theme_bg_color px-3 py-2">
                <span class="h5">
                    @if (isset($sale))
                        {{ __('UPDATE') }}
                    @else
                        {{ __('CREATE') }}
                    @endif
                    {{ __('SALE') }}
                </span>

                <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminsale') }}"
                    role="button">{{ __('Back') }}</a>
                @if (App::make('possetting'))
                    @if (App::make('possetting')->is_hold && App::make('possetting')->is_holdreference)
                        <button wire:click.prevent="holdsale" class="btn btn-sm btn-danger shadow float-end mx-1"
                            role="button">{{ __('Hold') }}</button>
                    @elseif(App::make('possetting')->is_hold && !App::make('possetting')->is_holdreference)
                        <button wire:click.prevent="storeholdsale" class="btn btn-sm btn-danger shadow float-end mx-1"
                            role="button">{{ __('Hold') }}</button>
                    @endif
                @endif
            </div>

            {{-- Search Items --}}
            <div class="container">
                <div class="w-75 mx-auto">
                    <div class="d-flex">
                        <div class="col-md-11">
                            <input class="form-control mt-3 z-0" wire:model.live="product_selected" id="product_id"
                                wire:change="searchproduct" wire:keyup="searchproduct" type="text"
                                placeholder="{{ __('Search Products') }}..." wire:keyup.arrow-up="decrementHighlight"
                                wire:keydown.arrow-down="incrementHighlight" wire:keydown.enter="enterproduct"
                                wire:click="searchproductreset" autofocus>
                        </div>
                        {{-- <div class="col-md-1">
                            <div wire:loading class="spinner-border spinner-border-sm text-info mt-4 ms-4"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div> --}}
                    </div>

                    @error('product')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    @if (!empty($product_selected) && !empty($searchproductlist))
                        <ul class="list-group position-absolute w-75">
                            @if (!empty($searchproductlist))
                                @foreach ($searchproductlist as $i => $eachsearchproductlist)
                                    <li style="cursor: pointer;"
                                        class="list-group-item  {{ $highlightIndex === $i ? 'theme_bg_color text-white' : '' }}"
                                        wire:click="onclickproduct('{{ $eachsearchproductlist->id }}')">
                                        <h6>
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $eachsearchproductlist->sku }}
                                            </span>
                                            <span class="fw-bold">{{ $eachsearchproductlist->name }}</span>

                                            <span class="badge bg-primary rounded-pill float-end">
                                                {{ $eachsearchproductlist->stock }}
                                            </span>
                                        </h6>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <div class="card-body">
                <table class="table w-100 text-start table-borderless">
                    <thead>
                        <tr
                            class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                            <th width="10%">
                                {{ __('S.NO') }}
                            </th>
                            <th width="40%">
                                {{ __('PRODUCT NAME') }}
                            </th>
                            <th width="16%" class="text-center">
                                {{ __('RATE') }}
                            </th>
                            <th width="16%" class="text-center">
                                {{ __('QUANTITY') }}
                            </th>
                            <th width="16%" class="text-center">
                                {{ __('TOTAL') }}
                            </th>
                            <th width="2%"></th>
                        </tr>
                    </thead>
                    <tbody class="table-white">
                        @foreach ($product as $key => $eachproductlist)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>

                                    <span> {{ $eachproductlist['product_name'] }} </span>

                                </td>
                                <td>
                                    <input class="form-control text-end shadow-sm" style="border: 0px;"
                                        wire:model="product.{{ $key }}.product_rate"
                                        wire:change.debounce.650ms="productcalculation('{{ $key }}')"
                                        wire:keyup.debounce.650ms="productcalculation('{{ $key }}')"
                                        type="number">
                                    @error('product.' . $key . '.product_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input class="form-control text-center shadow-sm" style="border: 0px;"
                                        wire:model="product.{{ $key }}.product_quantity"
                                        wire:change.debounce.650ms="productcalculation('{{ $key }}')"
                                        wire:keyup.debounce.650ms="productcalculation('{{ $key }}')"
                                        type="number">
                                    @error('product.' . $key . '.product_quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="text-end">
                                    <div class="form-control text-end shadow-sm" style="border: 0px;">
                                        {{ number_format($eachproductlist['product_subtotal'], 2) }}
                                    </div>
                                    {{-- <span class="me-3" style="border: 0px;">
                                        {{ number_format($eachproductlist['product_subtotal'], 2) }} </span> --}}
                                </td>
                                <td>
                                    <svg class="text-danger" role='button'
                                        wire:click.prevent="removeitem({{ $key }})"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('Sub Total') }}
                            </td>
                            <td class="text-end">
                                <div class="form-control shadow-sm" style="border: 0px;">
                                    {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['sub_total'], 2) }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td width="14%">
                                {{ __('Extra Charges') }}
                            </td>
                            <td class="text-end">
                                <input class="form-control text-end shadow-sm" style="border: 0px;"
                                    wire:model.live="form.extra_charges" wire:change.debounce.650ms="overallcalc()"
                                    wire:keyup.debounce.650ms="overallcalc()" type="number" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('Discount') }}
                            </td>
                            <td>
                                <input class="form-control text-end shadow-sm" style="border: 0px;"
                                    wire:model="form.discount" wire:change.debounce.650ms="overallcalc()"
                                    wire:keyup.debounce.650ms="overallcalc()" type="number" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('Total') }}
                            </td>
                            <td>
                                <div class="form-control text-end shadow-sm" style="border: 0px;">
                                    {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['total'], 2) }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('Round Off') }}
                            </td>
                            <td>
                                <div class="form-control text-end shadow-sm" style="border: 0px;">
                                    {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['roundoff'], 2) }}
                                </div>
                            </td>
                        </tr>
                        @if ($tax_type == 3)
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    {{ __('VAT') }}
                                </td>
                                <td>
                                    <div class="form-control text-end shadow-sm" style="border: 0px;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['vat'], 2) }}
                                    </div>
                                </td>
                            </tr>
                        @elseif($tax_type == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    {{ __('SGST') }}
                                </td>
                                <td>
                                    <div class="form-control text-end shadow-sm" style="border: 0px;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['sgst'], 2) }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    {{ __('CGST') }}
                                </td>
                                <td>
                                    <div class="form-control text-end shadow-sm" style="border: 0px;">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['cgst'], 2) }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="received_amount" class="form-label">{{ __('Cash Received') }}
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control text-end shadow-sm" style="border: 0px;"
                                            wire:model.live="form.received_amount"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()" type="number" />
                                        @error('form.received_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="remaining_amount"
                                            class="form-label">{{ __('Amount Repay') }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control text-end shadow-sm" style="border: 0px;"
                                            wire:model.live="form.remaining_amount"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()" type="number" readonly />
                                    </div>
                                </div>

                            </td>
                            <td>
                                {{ __('Grand Total') }}
                            </td>
                            <td>
                                <input class="form-control text-end shadow-sm" style="border: 0px;"
                                    wire:model.live="form.grandtotal" wire:change="overallcalc()"
                                    wire:keyup="overallcalc()" type="number" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Customer --}}

            <div class="container">
                <div class="row g-3">
                    <div class="col-3 position-relative ">
                        <label class="form-label" for="customerphone">{{ __('CUSTOMER PHONE') }}</label>


                        <input class="form-control" wire:model.live="customerphone" id="customerphone"
                            type="number" wire:keyup.arrow-up="customerdecrement"
                            wire:keydown.arrow-down="customerincrement" wire:keydown.enter="entercustomer">
                        @error('form.customer_phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($customerphone) && !empty($searchcustomerlist))
                            <ul class="list-group position-absolute w-100 ">
                                @if (!empty($searchcustomerlist))
                                    @foreach ($searchcustomerlist as $skey => $eachsearchcustomerlist)
                                        <li style="cursor: pointer;"
                                            class="list-group-item d-lg-flex justify-content-between align-items-start w-100 {{ $customerhighlightIndex === $skey ? 'theme_bg_color text-white' : '' }}"
                                            wire:click="clickcustomer('{{ $eachsearchcustomerlist->id }}')">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ $eachsearchcustomerlist->name }}</div>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">Phone :
                                                {{ $eachsearchcustomerlist['phone'] }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif

                    </div>

                    <div class="col-3">
                        <label for="customer_name" class="form-label">{{ __('CUSTOMER NAME') }}</label>
                        <input wire:model.live="form.customer_name" type="text" class="form-control"
                            id="customer_name" readonly>
                    </div>

                    <div class="col-3">
                        <label for="customer_email" class="form-label">{{ __('CUSTOMER EMAIL') }}</label>
                        <input wire:model.live="form.customer_email" type="text" class="form-control"
                            id="customer_email" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="noteid" class="form-label">{{ __('NOTE') }}</label>
                        <textarea wire:model.blur="form.note" class="form-control" id="noteid" rows="2"></textarea>
                        @error('form.note')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Button --}}


            <div class="text-muted text-center m-2">
                <button wire:click.prevent="submit(1)" type="button" class="btn btn-success  rounded-3"
                    style="font-size:12px;">
                    {{ __('CASH') }}
                </button>
                <button wire:click.prevent="submit(2)" type="button" class="btn btn-success  rounded-3"
                    style="font-size:12px;">
                    {{ __('CARD') }}
                </button>
                <button wire:click.prevent="submit(3)" type="button" class="btn btn-success  rounded-3"
                    style="font-size:12px;">
                    {{ __('ONLINE') }}
                </button>
                @if (App::make('possetting'))
                    @if (App::make('possetting')->is_hold && App::make('possetting')->is_holdreference)
                        <button wire:click.prevent="holdsale" class="btn btn-warning rounded-3"
                            role="button">{{ __('Hold') }}</button>
                    @elseif(App::make('possetting')->is_hold && !App::make('possetting')->is_holdreference)
                        <button wire:click.prevent="storeholdsale" class="btn btn-warning rounded-3"
                            role="button">{{ __('Hold') }}</button>
                    @endif
                @endif
                <a href="{{ route('adminsale') }}" type="button" class="btn btn-danger rounded-3"
                    style="font-size:12px;">{{ __('CANCEL') }}</a>
            </div>

        </div>

    </form>
    @include('livewire.admin.sale.holdsalemodal')
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('holdsalemodal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('holdsaleModal'))
                myModal.show();
            });
        });
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
</div>
