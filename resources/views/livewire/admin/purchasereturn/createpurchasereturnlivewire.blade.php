<div>
    <form wire:submit.prevent="store" onkeydown="return event.key != 'Enter';" enctype="multipart/form-data" novalidate>
        <div class="card bg-white">
            <div class="card-header text-white theme_bg_color px-3 py-2">
                <span class="h5">{{ __('PURCHASE RETURN') }}</span>
                <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminpurchase') }}"
                    role="button">Back</a>
            </div>
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-4 position-relative ">
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

                    <div class="col-4">
                        <label for="supplier_phone" class="form-label">{{ __('SUPPLIER PHONE') }}</label>
                        {{-- <span class="text-danger fw-bold">*</span> --}}
                        <input wire:model.live="form.supplier_phone" type="number" class="form-control"
                            id="supplier_phone" readonly>
                        @error('form.supplier_phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="supplier_address" class="form-label">{{ __('SUPPLIER ADDRESS') }}</label>
                        {{-- <span class="text-danger fw-bold">*</span> --}}
                        <textarea wire:model.live="form.supplier_address" class="form-control" id="supplier_address"
                            rows="{{ isset($rows) ? $rows : 2 }}" readonly></textarea>
                        @error('form.supplier_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="supplier_email" class="form-label">{{ __('SUPPLIER EMAIL') }}</label>
                        <input wire:model.live="form.supplier_email" type="text" class="form-control"
                            id="supplier_email" readonly>
                        @error('form.supplier_email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="gst" class="form-label">{{ __('GST') }}</label>
                        <input wire:model.live="form.gst" type="text" class="form-control" id="gst" readonly>
                        @error('form.gst')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="pan" class="form-label">{{ __('PAN') }}</label>
                        <input wire:model.live="form.pan" type="text" class="form-control" id="pan" readonly>
                        @error('form.pan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="container mb-4">

                <div class="w-75 mx-auto position-relative">
                    <label for="purchase" class="form-label">{{ __('BILL NUMBER') }}</label>
                    <span class="text-danger fw-bold">*</span>
                    <input autocomplete="off" type="text" class="form-control" id="purchase"
                        placeholder="{{ __('Search Bill Number') }} ..." wire:model.live="purchase"
                        wire:keydown.escape="resetData" wire:keydown.arrow-up="purchasedecrementHighlight"
                        wire:keydown.arrow-down="purchaseincrementHighlight" wire:keydown.enter="selectPurchase" />
                    @if (!empty($purchase))
                        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetData"></div>
                        <div class="position-absolute bg-white rounded-t-none shadow-lg list-group"
                            style="width:99%; z-index: 50;">
                            @if ($ispurchaseselected === false)
                                @if (!empty($purchaselist) && sizeof($purchaselist) > 0)
                                    @foreach ($purchaselist as $i => $eachpurchase)
                                        <div type="button"
                                            wire:click='selecthispurchase({{ $eachpurchase->id }},{{ "'" . $eachpurchase->uniqid . "'" }})'
                                            class="search-option-list list-item p-1 text-xs {{ $purchasehighlightIndex === $i ? 'theme_bg_color text-white' : '' }}">
                                            {{ $eachpurchase->uniqid }}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="list-item p-1">No results!</div>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
                @if (sizeof($purchasereturitem) > 0)
                    <div>
                        <div class="card-body">
                            <div>
                                <table class="table table-bordered text-center text-primary table-light mt-3">
                                    <thead
                                        class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                                        <tr>
                                            <th scope="col" width="31%" class="fs-6">{{ __('PRODUCT NAME') }}
                                            </th>
                                            <th scope="col" width="15%" class="fs-6">
                                                {{ __('PURCHASE PRICE') }}</th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('PRICE') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('PURCHASED') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('RETURNED') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('QUANTITY') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('SELECT') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-primary">
                                        @foreach ($purchasereturitem as $key => $value)
                                            <tr class="text-black bg-white">
                                                <td class="bg-white">

                                                    {{ $value['product_name'] }}
                                                </td>
                                                <td class="bg-white">
                                                    {{ $value['purchaseprice'] }}
                                                </td>
                                                <td class="bg-white">
                                                    {{ $value['price'] }}
                                                </td>
                                                <td class="bg-white">
                                                    {{ $value['quantity'] }}
                                                </td>
                                                <td class="bg-white">
                                                    {{ $value['returned_quantity'] }}
                                                </td>
                                                <td class="{{ $purchasereturitem[$key]['is_selected'] ? 'bg-white' : 'bg-muted' }}"
                                                    style="width:10%;">
                                                    @if ($purchasereturitem[$key]['is_selected'])
                                                        <input wire:change="purchasereturitem({{ $key }})"
                                                            wire:keyup="purchasereturitem({{ $key }})"
                                                            wire:model.live="purchasereturitem.{{ $key }}.return_quantity"
                                                            type="text" class="form-control text-center bg-white"
                                                            placeholder="{{ __('qty') }}"
                                                            {{ $purchasereturitem[$key]['is_selected'] ? '' : 'disabled' }}>
                                                        @error('purchasereturitem.' . $key . '.return_quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    @else
                                                        {{ $purchasereturitem[$key]['return_quantity'] }}
                                                    @endif
                                                </td>
                                                <td class="bg-white">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input"
                                                                wire:model.live="purchasereturitem.{{ $key }}.is_selected"
                                                                type="checkbox" id="flexCheckDefault">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3 p-3">
                                    @include('helper.formhelper.form', [
                                        'type' => 'textarea',
                                        'fieldname' => 'return_note',
                                        'labelname' => __('RETURN NOTE'),
                                        'labelidname' => 'return_note',
                                        'required' => true,
                                        'readonly' => false,
                                        'col' => 'col-md-4',
                                    ])
                                    <div class="col-md-4 mb-3">
                                        <label for="return_amoountid"
                                            class="form-label">{{ __('DEBIT AMOUNT') }}</label>
                                        <input wire:model.lazy="debit_amount.grand_total" type="text"
                                            class="form-control" id="return_amoountid" readonly>
                                    </div>
                                </div>
                                <div class="text-center d-flex justify-content-center gap-2 align-items-center">
                                    <div wire:loading wire:target="createpurchasesreturn" class="mt-2">
                                        <div class="spinner-border loadingspinner" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success"
                                        {{ $submitbtn ? '' : 'disabled' }}>Save</button>
                                    <a href={{ route('purchasereturncreate') }} class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </form>
</div>
