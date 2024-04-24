<div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if ($showdata)
            <div class="modal-content">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="showModalLabel"> {{ __('SHOW SALE') }} :
                        {{ $showdata->uniqid }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row">
                        @include('helper.formhelper.showlabel', [
                            'name' => __('SALE ID'),
                            'value' => $showdata->uniqid,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @if ($showdata->customer_id)
                            @include('helper.formhelper.showlabel', [
                                'name' => __('CUSTOMER NAME'),
                                'value' => $showdata->customer->name,
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                            @include('helper.formhelper.showlabel', [
                                'name' => __('CUSTOMER PHONE'),
                                'value' => $showdata->customer->phone,
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                            @include('helper.formhelper.showlabel', [
                                'name' => __('CUSTOMER EMAIL'),
                                'value' => $showdata->customer->email,
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                        @endif
                        @include('helper.formhelper.showlabel', [
                            'name' => __('TOTAL ITEMS'),
                            'value' => $showdata->total_items,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PAYMENT MODE'),
                            'value' => $showdata->mode ? config('archive.mode')[$showdata->mode] : '',
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('NOTE'),
                            'value' => $showdata->note,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('CREATED BY'),
                            'value' => $showdata->createdby?->name,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('CREATED AT'),
                            'value' => $showdata->created_at->format('d-M-Y h:i'),
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @if ($showdata->updated_id)
                            @include('helper.formhelper.showlabel', [
                                'name' => __('UPDATED BY'),
                                'value' => $showdata->updatedby?->name,
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                            @include('helper.formhelper.showlabel', [
                                'name' => __('UPDATED AT'),
                                'value' => $showdata->updated_at->format('d-M-Y h:i'),
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                        @endif

                        <div class="container my-3">
                            <table class="table w-100 text-start table-borderless">
                                <thead>
                                    <tr
                                        class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                                        <th class="border">
                                            {{ __('ID') }}
                                        </th>
                                        <th colspan="2" class="border">
                                            {{ __('PRODUCT NAME') }}
                                        </th>
                                        <th class="border">
                                            {{ __('QUANTITY') }}
                                        </th>
                                        <th class="border">
                                            {{ __('PRICE') }}
                                        </th>
                                        <th class="text-end border">
                                            {{ __('TOTAL') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showdata->saleitem as $eachsaleitem)
                                        <tr>
                                            <td class="border">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td colspan="2" class="border">
                                                {{ $eachsaleitem['product_name'] }}
                                            </td>
                                            <td class="border">
                                                {{ $eachsaleitem['quantity'] }}
                                            </td>
                                            <td class="border">
                                                {{ number_format($eachsaleitem['price'], 2) }}
                                            </td>
                                            <td class="text-end border">
                                                {{ number_format($eachsaleitem['total'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="border">
                                            {{ __('SUB TOTAL') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->sub_total, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="border">
                                            {{ __('EXTRA CHARGES') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->extra_charges, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="border">
                                            {{ __('DISCOUNT') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->discount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="border">
                                            {{ __('TOTAL') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->total, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="border">
                                            {{ __('ROUND OFF') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->roundoff, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">
                                            {{ __('AMOUNT RECIEVED') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->received_amount, 2) }}
                                        </td>
                                        <td class="border">
                                            {{ __('AMOUNT REPAY') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->remaining_amount, 2) }}
                                        </td>
                                        <td class="border">
                                            {{ __('GRAND TOTAL') }}
                                        </td>
                                        <td class="text-end border">
                                            {{ number_format($showdata->grandtotal, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-2 py-1">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        @endif
    </div>
</div>
