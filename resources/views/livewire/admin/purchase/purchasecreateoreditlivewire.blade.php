<form wire:submit.prevent="storepurchase" onkeydown="return event.key != 'Enter';" enctype="multipart/form-data"
    novalidate>
    <div class="card bg-white">
        <div class="card-header text-white theme_bg_color px-3 py-2">
            <span class="h5">
                @if ($purchase)
                    {{ __('UPDATE') }}
                @else
                    {{ __('CREATE') }}
                @endif {{ __('PURCHASE') }}
            </span>
            <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminpurchase') }}"
                role="button">Back</a>
        </div>
        <div class="card-body">

            <div class="row g-3">

                <div class="col-3 position-relative ">
                    <label class="form-label" for="suppliername">{{ __('SUPPLIER NAME') }}<span
                            class="text-danger fw-semibold p-1">*</span></label>


                    <input class="form-control" wire:model.live="suppliername" id="suppliername" type="text"
                        wire:keyup.arrow-up="supplierdecrement" wire:keydown.arrow-down="supplierincrement"
                        wire:keydown.enter="entersupplier" autofocus>
                    @error('form.supplier_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror



                    @if (!empty($suppliername) && !empty($searchsupplierlist))
                        <ul class="list-group position-absolute ">
                            @if (!empty($searchsupplierlist))
                                @foreach ($searchsupplierlist as $skey => $eachsearchsupplierlist)
                                    <li style="cursor: pointer;"
                                        class="list-group-item d-flex justify-content-between align-items-start  w-100 {{ $supplierhighlightIndex === $skey ? 'theme_bg_color text-white' : '' }}"
                                        wire:click="clicksupplier('{{ $eachsearchsupplierlist->id }}')">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $eachsearchsupplierlist->name }}</div>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">Phone :
                                            {{ $eachsearchsupplierlist['phone'] }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @endif

                </div>

                @include('helper.formhelper.form', [
                    'type' => 'date',
                    'fieldname' => 'form.purchase_date',
                    'labelname' => __('PURCHASE DATE'),
                    'labelidname' => 'purchase_dateid',
                    'required' => true,
                    'readonly' => false,
                    'col' => 'col-md-3',
                ])

                <div class="col-3">
                    <label for="supplier_phone" class="form-label">{{ __('SUPPLIER PHONE') }}</label>
                    {{-- <span class="text-danger fw-bold">*</span> --}}
                    <input wire:model.live="form.supplier_phone" type="number" class="form-control" id="supplier_phone"
                        readonly>
                    @error('form.supplier_phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3">
                    <label for="supplier_address" class="form-label">{{ __('SUPPLIER ADDRESS') }}</label>
                    {{-- <span class="text-danger fw-bold">*</span> --}}
                    <textarea wire:model.live="form.supplier_address" class="form-control" id="supplier_address"
                        rows="{{ isset($rows) ? $rows : 2 }}" readonly></textarea>
                    @error('form.supplier_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3 mt-0">
                    <label for="supplier_email" class="form-label">{{ __('SUPPLIER EMAIL') }}</label>
                    <input wire:model.live="form.supplier_email" type="text" class="form-control" id="supplier_email"
                        readonly>
                    @error('form.supplier_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3  mt-0">
                    <label for="gst" class="form-label">{{ __('GST') }}</label>
                    <input wire:model.live="form.gst" type="text" class="form-control" id="gst" readonly>
                    @error('form.gst')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3  mt-0">
                    <label for="pan" class="form-label">{{ __('PAN') }}</label>
                    <input wire:model.live="form.pan" type="text" class="form-control" id="pan" readonly>
                    @error('form.pan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- @include('helper.formhelper.form', [
                    'type' => 'textarea',
                    'fieldname' => 'form.note',
                    'labelname' => 'NOTE',
                    'labelidname' => 'noteid',
                    'required' => false,
                    'readonly' => false,
                    'col' => 'col-md-3',
                ]) --}}
            </div>
        </div>

        <div class="container">
            <div class="w-75 mx-auto">
                <div class="d-flex">
                    <div class="col-md-11">
                        <input class="form-control mt-3 z-0" wire:model.delay="product_selected" id="product_id"
                            wire:change="searchproduct" wire:keyup="searchproduct" type="text"
                            placeholder="{{ __('Search Products') }}..." wire:keyup.arrow-up="decrementHighlight"
                            wire:keydown.arrow-down="incrementHighlight" wire:keydown.enter="enterproduct"
                            wire:click="searchproductreset">
                    </div>
                    <div class="col-md-1">
                        <div wire:loading class="spinner-border spinner-border-sm text-info mt-4 ms-4" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
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

        {{-- Product Table --}}

        <div class="card-body">
            <table class="table w-100 text-start table-borderless">
                <thead>
                    <tr
                        class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                        <th width="10%">
                            {{ __('S.NO') }}
                        </th>
                        <th width="40%">
                            {{ __('NAME') }}
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
                                {{-- Rate --}}
                                <input class="form-control text-end shadow-sm" style="border: 0px;"
                                    wire:model="product.{{ $key }}.product_rate"
                                    wire:change="productcalculation('{{ $key }}')"
                                    wire:keyup="productcalculation('{{ $key }}')" type="number">

                                @error('product.' . $key . '.product_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                {{-- Quantity --}}
                                <input class="form-control text-center shadow-sm" style="border: 0px;"
                                    wire:model="product.{{ $key }}.product_quantity"
                                    wire:change="productcalculation('{{ $key }}')"
                                    wire:keyup="productcalculation('{{ $key }}')" type="number">
                                @error('product.' . $key . '.product_quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                {{-- Sub Total --}}
                                <div class="form-control text-end shadow-sm" style="border: 0px;">
                                    {{ number_format($eachproductlist['product_subtotal'], 2) }}
                                </div>
                                {{-- <span class="text-end" style="border: 0px;">
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
                        <td>
                            {{ __('Freight Charges') }}
                        </td>
                        <td class="text-end">
                            <input class="form-control text-end shadow-sm" style="border: 0px;"
                                wire:model.delay="form.freight_charges" wire:change="overallcalc()"
                                wire:keyup="overallcalc()" type="number" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            {{ __('Adjustment') }}
                        </td>
                        <td>
                            <input class="form-control text-end shadow-sm" style="border: 0px;"
                                wire:model.delay="form.adjustment" wire:change="overallcalc()"
                                wire:keyup="overallcalc()" type="number" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            {{ __('Discount') }}
                        </td>
                        <td>
                            <input class="form-control text-end shadow-sm" style="border: 0px;"
                                wire:model.delay="form.discount" wire:change="overallcalc()"
                                wire:keyup="overallcalc()" type="number" />
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
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('IGST') }}
                            </td>
                            <td>
                                <div class="form-control text-end shadow-sm" style="border: 0px;">
                                    {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['igst'], 2) }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                {{ __('CESS') }}
                            </td>
                            <td>
                                <div class="form-control text-end shadow-sm" style="border: 0px;">
                                    {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['cess'], 2) }}
                                </div>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td rowspan="3" colspan="3">
                            @include('helper.formhelper.form', [
                                'type' => 'textarea',
                                'fieldname' => 'form.note',
                                'labelname' => __('NOTE'),
                                'labelidname' => 'noteid',
                                'required' => false,
                                'readonly' => false,
                                'col' => 'col-md-6',
                            ])
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Round Off') }}
                        </td>
                        <td>
                            <div class="form-control text-end shadow-sm" style="border: 0px;">
                                {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['roundoff'], 2) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Grand Total') }}
                        </td>
                        <td>
                            <input class="form-control text-end shadow-sm" style="border: 0px;"
                                wire:model.delay="form.grandtotal" wire:change="overallcalc()"
                                wire:keyup="overallcalc()" type="number" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-muted text-end">
            <a href="{{ route('adminpurchase') }}" type="button" class="btn btn-secondary">{{ __('Close') }}</a>
            <button type="submit" class="btn btn-primary">
                @if ($purchase)
                    {{ __('Update') }}
                @else
                    {{ __('Create') }}
                @endif
                <span wire:loading.delay class="spinner-border spinner-border-sm" role="status" aria-hidden="true">
                </span>
            </button>
        </div>
    </div>

</form>
