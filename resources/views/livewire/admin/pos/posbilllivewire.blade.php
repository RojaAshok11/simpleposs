<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-6 position-relative">
                            <div class="col input-group input-group-sm mb-3">
                                <span class="input-group-text"><i class="bi bi-telephone-plus"></i></span>
                                <input type="number" class="form-control" placeholder="Customer Mobile No"
                                    placeholder="Customer Phone" wire:model.live="customerphone" id="customerphone"
                                    wire:keyup.arrow-up="customerdecrement" wire:keydown.arrow-down="customerincrement"
                                    wire:keydown.enter="entercustomer">
                            </div>

                            @if (!empty($customerphone) && !empty($searchcustomerlist))
                                <ul class="list-group position-absolute">
                                    @if (!empty($searchcustomerlist))
                                        @foreach ($searchcustomerlist as $skey => $eachsearchcustomerlist)
                                            <li style="cursor: pointer; background-color:
                                                {{ $customerhighlightIndex == $skey ? strtolower(App::make('themesetting')->theme_bg_color) . ';color:white' : '' }};"
                                                class="list-group-item d-flex justify-content-between align-items-start w-100"
                                                wire:click="clickcustomer('{{ $eachsearchcustomerlist->id }}')">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">
                                                        {{ $eachsearchcustomerlist->name }}
                                                    </div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">Phone :
                                                    {{ $eachsearchcustomerlist['phone'] }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="col input-group input-group-sm mb-3">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input wire:model.live="form.customer_name" id="customer_name" type="text"
                                    class="form-control" placeholder="Customer Name">
                            </div>
                        </div>
                    </div>

                    <table class="table table-sm mt-1 mb-0 px-2">
                        <thead>
                            <tr
                                class="table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                                <th width="35%" style="font-size:12px">
                                    PRODUCT
                                </th>
                                <th width="25%" class="text-center" style="font-size:12px">QUANTITY
                                </th>
                                <th width="15%" class="text-center" style="font-size:12px">PRICE</th>
                                <th width="25%" class="text-center" style="font-size:12px">TOTAL
                                    <svg onclick="window.location.reload();" role='button'
                                        xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                        <path
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                    </svg>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="overflow-auto" style="height:200px;">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @if ($productlist)
                                        @foreach ($productlist as $key => $eachproduct)
                                            <tr>
                                                <td style="font-size: 14px" class="" width="35%">
                                                    <span><span class="fw-bolder">{{ $key + 1 }}.</span>
                                                        {{ $eachproduct['product_name'] }} </span>
                                                </td>
                                                <td width="25%">
                                                    <div class="row">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="pe-1">
                                                                <div wire:loading.attr="disabled"
                                                                    wire:click="subitem({{ $key }})"
                                                                    role="button"
                                                                    class="badge bg-danger text-wrap {{ $eachproduct['product_quantity'] <= 1 ? 'invisible' : '' }}">
                                                                    <span><i class="bi bi-dash-lg"></i></span>
                                                                </div>
                                                            </div>
                                                            <input style="height:100%; font-size: 12px"
                                                                class="form-control text-center border-black fw-bolder p-0"
                                                                wire:model="productlist.{{ $key }}.product_quantity"
                                                                wire:change="productcalculation('{{ $key }}')"
                                                                wire:keyup="productcalculation('{{ $key }}')">
                                                            <div class="ps-1">
                                                                <div wire:loading.attr="disabled"
                                                                    wire:click="additem({{ $key }})"
                                                                    role="button" class="badge bg-success text-wrap ">
                                                                    <span><i class="bi bi-plus-lg"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center" width="15%">
                                                    <div>
                                                        <input style="height:100%; font-size: 12px"
                                                            class="form-control text-end border-black fw-bolder p-1"
                                                            wire:model="productlist.{{ $key }}.product_rate"
                                                            wire:change="productcalculation('{{ $key }}')"
                                                            wire:keyup="productcalculation('{{ $key }}')">
                                                    </div>
                                                </td>
                                                <td class="text-center" width="25%">
                                                    <div class="fw-bolder ms-2 mt-1" style="height:10%;font-size: 12px">
                                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($eachproduct['product_subtotal'], 2) }}
                                                        <svg wire:click="removeitem({{ $key }},'{{ $eachproduct['product_saleitemid'] }}')"
                                                            class="text-danger me-2" role='button'
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-trash"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                            <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                        </svg>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <div class="container mt-4 text-center">
                                            <div>
                                                <p>
                                                    <svg width="92" height="76" viewBox="0 0 92 76"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.19204 66.225V68.85H5.71704V70.515H2.19204V73.29H6.16704V75H0.092041V64.515H6.16704V66.225H2.19204Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M19.4904 64.53V75H17.3904V68.19L14.5854 75H12.9954L10.1754 68.19V75H8.07544V64.53H10.4604L13.7904 72.315L17.1204 64.53H19.4904Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M29.2017 67.77C29.2017 68.33 29.0667 68.855 28.7966 69.345C28.5367 69.835 28.1217 70.23 27.5517 70.53C26.9917 70.83 26.2817 70.98 25.4216 70.98H23.6667V75H21.5667V64.53H25.4216C26.2316 64.53 26.9216 64.67 27.4916 64.95C28.0616 65.23 28.4867 65.615 28.7667 66.105C29.0567 66.595 29.2017 67.15 29.2017 67.77ZM25.3316 69.285C25.9116 69.285 26.3417 69.155 26.6217 68.895C26.9017 68.625 27.0417 68.25 27.0417 67.77C27.0417 66.75 26.4716 66.24 25.3316 66.24H23.6667V69.285H25.3316Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M37.8176 64.53V66.225H35.0276V75H32.9276V66.225H30.1376V64.53H37.8176Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M47.6749 64.53L44.1349 71.355V75H42.0349V71.355L38.4799 64.53H40.8499L43.0999 69.315L45.3349 64.53H47.6749Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M51.9502 69.75C51.9502 68.72 52.1802 67.8 52.6402 66.99C53.1102 66.17 53.7452 65.535 54.5452 65.085C55.3552 64.625 56.2602 64.395 57.2602 64.395C58.4302 64.395 59.4552 64.695 60.3352 65.295C61.2152 65.895 61.8302 66.725 62.1802 67.785H59.7652C59.5252 67.285 59.1852 66.91 58.7452 66.66C58.3152 66.41 57.8152 66.285 57.2452 66.285C56.6352 66.285 56.0902 66.43 55.6102 66.72C55.1402 67 54.7702 67.4 54.5002 67.92C54.2402 68.44 54.1102 69.05 54.1102 69.75C54.1102 70.44 54.2402 71.05 54.5002 71.58C54.7702 72.1 55.1402 72.505 55.6102 72.795C56.0902 73.075 56.6352 73.215 57.2452 73.215C57.8152 73.215 58.3152 73.09 58.7452 72.84C59.1852 72.58 59.5252 72.2 59.7652 71.7H62.1802C61.8302 72.77 61.2152 73.605 60.3352 74.205C59.4652 74.795 58.4402 75.09 57.2602 75.09C56.2602 75.09 55.3552 74.865 54.5452 74.415C53.7452 73.955 53.1102 73.32 52.6402 72.51C52.1802 71.7 51.9502 70.78 51.9502 69.75Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M70.3939 73.005H66.2239L65.5339 75H63.3289L67.0939 64.515H69.5389L73.3039 75H71.0839L70.3939 73.005ZM69.8239 71.325L68.3089 66.945L66.7939 71.325H69.8239Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M80.1112 75L77.8012 70.92H76.8112V75H74.7112V64.53H78.6412C79.4512 64.53 80.1412 64.675 80.7112 64.965C81.2812 65.245 81.7062 65.63 81.9862 66.12C82.2762 66.6 82.4212 67.14 82.4212 67.74C82.4212 68.43 82.2212 69.055 81.8212 69.615C81.4212 70.165 80.8262 70.545 80.0362 70.755L82.5412 75H80.1112ZM76.8112 69.345H78.5662C79.1362 69.345 79.5612 69.21 79.8412 68.94C80.1212 68.66 80.2612 68.275 80.2612 67.785C80.2612 67.305 80.1212 66.935 79.8412 66.675C79.5612 66.405 79.1362 66.27 78.5662 66.27H76.8112V69.345Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M91.4456 64.53V66.225H88.6556V75H86.5556V66.225H83.7656V64.53H91.4456Z"
                                                            fill="#E4E4E4" />
                                                        <path
                                                            d="M68.5377 10.5179C68.3534 10.2975 68.123 10.1201 67.8627 9.99845C67.6024 9.87678 67.3186 9.81374 67.0313 9.81379H27.4525L26.2528 3.22383C26.0885 2.31933 25.6119 1.50119 24.9062 0.912049C24.2005 0.322907 23.3104 0.000132865 22.3911 0H17.9627C17.4421 0 16.9429 0.20679 16.5748 0.574879C16.2067 0.942967 15.9999 1.4422 15.9999 1.96276C15.9999 2.48331 16.2067 2.98255 16.5748 3.35064C16.9429 3.71873 17.4421 3.92552 17.9627 3.92552H22.3788L28.6498 38.3449C28.8345 39.3657 29.2856 40.3196 29.9575 41.11C29.0302 41.9761 28.3609 43.0821 28.0238 44.3054C27.6867 45.5286 27.695 46.8214 28.0478 48.0402C28.4006 49.259 29.084 50.3564 30.0223 51.2105C30.9606 52.0646 32.1172 52.6422 33.3637 52.8791C34.6103 53.1161 35.8981 53.0032 37.0843 52.5529C38.2706 52.1027 39.309 51.3326 40.0844 50.3282C40.8597 49.3238 41.3418 48.1243 41.4771 46.8627C41.6123 45.6011 41.3955 44.3266 40.8507 43.1807H51.9942C51.5551 44.1 51.3279 45.1061 51.3293 46.1248C51.3293 47.4835 51.7322 48.8117 52.4871 49.9414C53.2419 51.0711 54.3148 51.9516 55.57 52.4716C56.8253 52.9915 58.2065 53.1275 59.5391 52.8625C60.8717 52.5974 62.0957 51.9431 63.0565 50.9824C64.0172 50.0217 64.6715 48.7976 64.9365 47.465C65.2016 46.1324 65.0656 44.7512 64.5456 43.4959C64.0257 42.2407 63.1452 41.1678 62.0155 40.4129C60.8858 39.6581 59.5576 39.2552 58.1989 39.2552H34.4424C33.9827 39.2551 33.5377 39.0937 33.1848 38.7991C32.8319 38.5046 32.5937 38.0955 32.5115 37.6432L31.7338 33.3669H60.1936C61.5725 33.3667 62.9077 32.8825 63.9662 31.9988C65.0248 31.1151 65.7396 29.8879 65.9861 28.5311L68.9695 12.1274C69.02 11.8439 69.0075 11.5527 68.9329 11.2746C68.8582 10.9964 68.7233 10.7381 68.5377 10.5179ZM58.1989 43.1807C58.7812 43.1807 59.3504 43.3534 59.8346 43.6769C60.3187 44.0004 60.6961 44.4602 60.9189 44.9982C61.1418 45.5361 61.2001 46.1281 61.0865 46.6992C60.9729 47.2703 60.6925 47.7949 60.2807 48.2066C59.869 48.6184 59.3444 48.8988 58.7733 49.0124C58.2022 49.126 57.6102 49.0677 57.0723 48.8448C56.5343 48.622 56.0745 48.2447 55.751 47.7605C55.4275 47.2763 55.2548 46.7071 55.2548 46.1248C55.2548 45.344 55.565 44.5951 56.1171 44.043C56.6693 43.4909 57.4181 43.1807 58.1989 43.1807ZM34.646 43.1807C35.2283 43.1807 35.7975 43.3534 36.2817 43.6769C36.7658 44.0004 37.1432 44.4602 37.366 44.9982C37.5888 45.5361 37.6471 46.1281 37.5335 46.6992C37.4199 47.2703 37.1395 47.7949 36.7278 48.2066C36.3161 48.6184 35.7915 48.8988 35.2204 49.0124C34.6493 49.126 34.0573 49.0677 33.5193 48.8448C32.9814 48.622 32.5215 48.2447 32.198 47.7605C31.8745 47.2763 31.7019 46.7071 31.7019 46.1248C31.7019 45.344 32.0121 44.5951 32.5642 44.043C33.1163 43.4909 33.8652 43.1807 34.646 43.1807Z"
                                                            fill="#E4E4E4" />
                                                    </svg>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                    <div class="row mt-2 px-2">
                        <div class="col-md-6">
                            <div class="col-12 pe-0">
                                <div class="row align-items-center">
                                    <label class="fw-bold col-7 col-form-label"
                                        style="font-size:10px">DISCOUNT</label>
                                    <div class="col-5">
                                        <input type="number" class="form-control fw-bolder text-end"
                                            style="height:10%; font-size: 12px" wire:model="form.discount"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-12">
                                <div class="row mt-2">
                                    <span class="fw-bold col-6" style="font-size: 10px">SUB
                                        TOTAL</span>
                                    <div class="col-5 col-form-control fw-bolder text-end"
                                        style="height:10%;font-size: 12px">
                                        {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['sub_total'], 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-12 pe-0">
                                <div class="row align-items-center">
                                    <label class="fw-bold col-7 col-form-label" style="font-size:10px">EXTRA
                                        CHARGES</label>
                                    <div class="col-5">
                                        <input type="number" class="form-control fw-bolder text-end"
                                            style="height:10%; font-size: 12px" wire:model="form.extra_charges"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <label class="fw-bold col-7 col-form-label"
                                        style="font-size:10px">RECIEVED</label>
                                    <div class="col-5">
                                        <input type="number" class="form-control fw-bolder text-end"
                                            style="height:10%; font-size: 12px" wire:model="form.received_amount"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()" />
                                    </div>
                                    @error('form.received_amount')
                                        <span class="text-danger fw-bold"
                                            style="font-size: 9px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if (App::make('possetting'))
                            @if (App::make('possetting')->tax_type == 2)
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <div class="row mt-2">
                                            <span class="fw-bold col-6" style="font-size: 10px">CGST</span>
                                            <div class="col-5 col-form-control fw-bolder text-end"
                                                style="height:10%;font-size: 12px">
                                                {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['cgst'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <div class="row mt-2">
                                            <span class="fw-bold col-6" style="font-size: 10px">SGST</span>
                                            <div class="col-5 col-form-control fw-bolder text-end"
                                                style="height:10%;font-size: 12px">
                                                {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['sgst'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(App::make('possetting')->tax_type == 3)
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <div class="row mt-2">
                                            <span class="fw-bold col-6" style="font-size: 10px">VAT</span>
                                            <div class="col-5 col-form-control fw-bolder text-end"
                                                style="height:10%;font-size: 12px">
                                                {{ App::make('currencymaster') ? App::make('currencymaster')->currency : '₹' }}{{ number_format($form['vat'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="col-md-6">
                            <div class="col-12 pe-0">
                                <div class="row align-items-center">
                                    <label class="fw-bold col-7 col-form-label" style="font-size:10px">AMOUNT
                                        REPAY</label>
                                    <div class="col-5">
                                        <input type="number"
                                            class="form-control fw-bolder text-end {{ $form['remaining_amount'] >= 1 ? 'text-success' : 'text-danger' }}"
                                            style="height:10%; font-size: 12px"
                                            wire:model.blur="form.remaining_amount" wire:change="overallcalc()"
                                            wire:keyup="overallcalc()" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <label class="fw-bold col-7 col-form-label" style="font-size:10px">TOTAL
                                        AMOUNT</label>
                                    <div class="col-5">
                                        <input type="number" class="form-control fw-bolder text-end"
                                            style="height:10%; font-size: 12px" wire:model.blur="form.grandtotal"
                                            wire:change.debounce.650ms="overallcalc()"
                                            wire:keyup.debounce.650ms="overallcalc()" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 px-2 my-2">
            <button wire:click.prevent="submit(1)" type="button" class="btn rounded-3"
                style="font-size:12px; width:50%;background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};color:white">Cash</button>
            <button wire:click.prevent="submit(2)" type="button" class="btn btn-sm rounded-3"
                style="font-size:12px; width:50%;background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};color:white">Card</button>
            <button wire:click.prevent="submit(3)" type="button" class="btn btn-sm rounded-3"
                style="font-size:12px; width:50%;background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }};color:white">Online</button>
            @if (App::make('possetting'))
                @if (App::make('possetting')->is_hold && App::make('possetting')->is_holdreference)
                    <button wire:click.prevent="holdsale" class="btn btn-sm rounded-3 shadow"
                        style="font-size:12px;background:orange;color:white; width:50%" role="button">Hold</button>
                @elseif(App::make('possetting')->is_hold && !App::make('possetting')->is_holdreference)
                    <button wire:click.prevent="storeholdsale" class="btn btn-sm rounded-3 shadow"
                        style="font-size:12px;background:orange;color:white; width:50%" role="button">Hold</button>
                @endif
            @endif
            <button wire:click="pagerefresh" type="button" class="btn btn-danger btn-sm rounded-3"
                style="font-size:12px; width:50%">Cancel</button>
        </div>
    </div>
</div>
