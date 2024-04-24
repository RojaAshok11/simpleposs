<div>
    <div class="card bg-white shadow-sm">
        <div class="card-header text-white theme_bg_color">
            <div class="d-flex flex-row bd-highlight">
                <div class="flex-grow-1 bd-highlight mt-1"><span class="h5">{{ __('Sale Return') }}
                        {{ __('Create') }}</span></div>
                <div class="bd-highlight">
                    <a href="{{ route('adminsalereturn') }}" class="btn btn-sm btn-secondary shadow float-end mx-1">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-2 p-3 justify-content-center">
                <div class="col-md-6">
                    <div class="position-relative">
                        <label for="customer"
                            class="form-label fw-bold">{{ __('Search Customer Name / Mobile no') }}</label>
                        <input autocomplete="off" type="text" class="form-control" id="customer"
                            placeholder="{{ __('Search Customer') }} ..." wire:model.live="customer"
                            wire:keydown.escape="resetData" wire:keydown.arrow-up=" decrementHighlight"
                            wire:keydown.arrow-down="incrementHighlight" wire:keydown.enter="selectCustomer" />
                        @if (!empty($customer))
                            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetData"></div>
                            <div class="position-absolute bg-white rounded-t-none shadow-lg list-group"
                                style="width:99%; z-index: 50;">
                                @if ($iscustomerselected === false)
                                    @if (!empty($customerlist))
                                        @foreach ($customerlist as $i => $eachcustomer)
                                            <div type="button"
                                                wire:click='selecthiscustomer({{ $eachcustomer->id }},{{ "'" . $eachcustomer->phone . "'" }},{{ "'" . $eachcustomer->name . "'" }})'
                                                class="d-flex gap-4 justify-content-center search-option-list list-item p-1 text-xs {{ $highlightIndex === $i ? 'theme_bg_color text-white' : '' }}">
                                                <span>
                                                    {{ $eachcustomer->phone }}
                                                </span>
                                                <span>
                                                    {{ $eachcustomer->name }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="list-item p-1">No results!</div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 position-relative">
                    <label for="sale" class="form-label fw-bold">{{ __('Bill Number') }}</label>
                    <span class="text-danger fw-bold">*</span>
                    <input autocomplete="off" type="text" class="form-control" id="sale"
                        placeholder="{{ __('Search Bill Number') }} ..." wire:model.live="sale"
                        wire:keydown.escape="resetData" wire:keydown.arrow-up="saledecrementHighlight"
                        wire:keydown.arrow-down="saleincrementHighlight" wire:keydown.enter="selectSale" />
                    @if (!empty($sale))
                        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetData"></div>
                        <div class="position-absolute bg-white rounded-t-none shadow-lg list-group"
                            style="width:99%; z-index: 50;">
                            @if ($issaleselected === false)
                                @if (!empty($salelist) && sizeof($salelist) > 0)
                                    @foreach ($salelist as $i => $eachsale)
                                        <div type="button"
                                            wire:click='selecthissale({{ $eachsale->id }},{{ "'" . $eachsale->uniqid . "'" }})'
                                            class="search-option-list list-item p-1 text-xs {{ $salehighlightIndex === $i ? 'theme_bg_color text-white' : '' }}">
                                            {{ $eachsale->uniqid }}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="list-item p-1">No results!</div>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
                @if ($customer_id)
                    <div class="col-md-6">
                        <label for="" class="fw-bold">{{ __('Customer Name') }}</label>
                        <input type="text" class="form-control mt-2" value="{{ $customerselected->name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="fw-bold">{{ __('Customer Phone') }}</label>
                        <input type="text" class="form-control mt-2" value="{{ $customerselected->phone }}"
                            readonly>
                    </div>
                @endif
                <div class="justify-content-center mt-5" wire:loading wire:loading.class="d-flex"
                    wire:target="loadsalesitems, selecthissale">
                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                @if (sizeof($salereturitem) > 0)
                    <div>
                        <div class="card-body">
                            <div>
                                <table
                                    class="table table-bordered text-center theme_bg_color text-primary table-light mt-3">
                                    <thead
                                        class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                                        <tr>
                                            <th scope="col" width="28%" class="fs-6">{{ __('PRODUCT NAME') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('PRICE') }}</th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('SOLD PRICE') }}
                                            </th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('SOLD') }}</th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('RETURNED') }}</th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('QTY') }}</th>
                                            <th scope="col" width="12%" class="fs-6">{{ __('SELECT') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($salereturitem as $key => $value)
                                            <tr class="text-black">
                                                <td class="bg-white">

                                                    {{ $value['product_name'] }}
                                                </td>
                                                <td class="bg-white">
                                                    {{ $value['sellingprice'] }}
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
                                                <td class="{{ $salereturitem[$key]['is_selected'] ? 'bg-white' : 'bg-muted' }}"
                                                    style="width:10%;">
                                                    @if ($salereturitem[$key]['is_selected'])
                                                        <input wire:change="salereturitem({{ $key }})"
                                                            wire:keyup="salereturitem({{ $key }})"
                                                            wire:model.live="salereturitem.{{ $key }}.return_quantity"
                                                            type="text" class="form-control text-center bg-white"
                                                            placeholder="{{ __('qty') }}"
                                                            {{ $salereturitem[$key]['is_selected'] ? '' : 'disabled' }}>
                                                        @error('salereturitem.' . $key . '.return_quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    @else
                                                        {{ $salereturitem[$key]['return_quantity'] }}
                                                    @endif
                                                </td>
                                                <td class="bg-white">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input"
                                                                wire:model.live="salereturitem.{{ $key }}.is_selected"
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
                                <form wire:submit.prevent="store" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row g-3 p-3">
                                        <div class="col-md-4">
                                            <label for="return_note"
                                                class="form-label">{{ __('RETURN NOTE') }}</label>
                                            <span class="text-danger fw-bold">*</span>
                                            <textarea wire:model.blur="return_note" class="form-control" id="return_note" rows="2"></textarea>
                                            @error('return_note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="return_amoountid"
                                                class="form-label">{{ __('DEBIT AMOUNT') }}</label>
                                            <input wire:model.lazy="debit_amount.grand_total" type="text"
                                                class="form-control" id="return_amoountid" readonly>
                                        </div>
                                    </div>
                                    <div class="text-center d-flex justify-content-center gap-2 align-items-center">
                                        <div wire:loading wire:target="createsalesreturn" class="mt-2">
                                            <div class="spinner-border loadingspinner" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success"
                                            {{ $submitbtn ? '' : 'disabled' }}>{{ __('Save') }}</button>
                                        <a href={{ route('salereturncreate') }}
                                            class="btn btn-secondary">{{ __('Cancel') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
