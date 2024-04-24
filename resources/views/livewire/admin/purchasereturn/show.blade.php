<div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if ($showdata)
            <div class="modal-content">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="showModalLabel"> {{ __('SHOW PURCHASE RETURN') }} :
                        {{ $showdata->uniqid }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row">
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PURCHASE RETURN ID'),
                            'value' => $showdata->uniqid,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('SUPPLIER NAME'),
                            'value' => $showdata->supplier_name,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('SUPPLIER PHONE'),
                            'value' => $showdata->supplier_phone,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('SUPPLIER EMAIL'),
                            'value' => $showdata->supplier->email,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('SUPPLIER ADDRESS'),
                            'value' => $showdata->supplier->address,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('GST'),
                            'value' => $showdata->supplier->gst,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PAN'),
                            'value' => $showdata->supplier->pan,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PURCHASE DATE'),
                            'value' => $showdata->purchase->purchase_date
                                ? \Carbon\Carbon::parse($showdata->purchase_date)->format('d-m-Y')
                                : '',
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('RETURN NOTE'),
                            'value' => $showdata->issue_note,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('RETURN AMOUNT'),
                            'value' => $showdata->grand_total,
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
                            <table class="table w-100 table-borderless">
                                <thead>
                                    <tr
                                        class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                                        <th class="border text-center">
                                            {{ __('PRODUCT NAME') }}
                                        </th>
                                        <th class="border text-center">
                                            {{ __('RETURN QUANTITY') }}
                                        </th>
                                        <th class="border text-center">
                                            {{ __('TOTAL') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showdata->purchasereturnitem as $eachpurchasereturnitem)
                                        <tr>
                                            <td class="border text-center">
                                                {{ $eachpurchasereturnitem->product->name }}
                                            </td>
                                            <td class="border text-center">
                                                {{ $eachpurchasereturnitem->return_quantity }}
                                            </td>
                                            <td class="border text-center">
                                                {{ $eachpurchasereturnitem->total }}
                                            </td>
                                        </tr>
                                    @endforeach
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
