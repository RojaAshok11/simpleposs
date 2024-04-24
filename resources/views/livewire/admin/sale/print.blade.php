<div wire:ignore.self class="modal fade" id="printmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="printmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if ($showdata)
            <div class="modal-content">
                <div class="modal-header text-white theme_bg_color px-3 py-2"
                    style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }}">
                    <h5 class="modal-title" id="printmodalLabel">Sale : {{ $showdata->uniqid }} </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-4">

                        <div>
                            <div class="text-center">
                                <b>{{ App::make('companysetting') ? App::make('companysetting')->companyfullname : 'POS' }}</b>
                            </div>
                            <div class="text-center">
                                {{ App::make('companysetting') ? App::make('companysetting')->address : '' }}<br>
                                Ph : {{ App::make('companysetting') ? App::make('companysetting')->phone : '' }}
                                @if (App::make('companysetting')?->alternate_phone)
                                    ,
                                    {{ App::make('companysetting') ? App::make('companysetting')->alternate_phone : '' }}
                                @endif
                            </div>
                            <div style="border-bottom: 1px dashed black;"></div>
                            <div style="display:flex; justify-content:space-between;">
                                <div><b>Bill No : </b> {{ $showdata->uniqid }}</div>
                                <div><b>Bill Date : </b> {{ $showdata->created_at->format('d-m-Y h:i A') }}</div>
                            </div>
                            @if ($showdata->customer_id)
                                <div style="display:flex; justify-content:space-between; margin-bottom:2px;">
                                    <div><b>Customer Name : </b> {{ $showdata->customer_name }}</div>
                                    <div><b>Customer Phone : </b>{{ $showdata->customer_phone }}</div>
                                </div>
                            @endif
                            {{-- <div style="display:flex; justify-content:space-between; margin-bottom:2px;">
                                <div>Mode:
                                    <b>{{ $showdata->mode ? Config::get('archive.mode')[$showdata->mode] : null }}</b>
                                </div>
                            </div> --}}
                            <div style="border-bottom: 1px dashed black;"></div>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th
                                            style="width: 55%; padding:3px 0px; font-size: 14px; text-align:left;border-bottom: 1px solid black;">
                                            Item
                                            Name</th>
                                        @if (App::make('possetting')->tax_type == 2)
                                            <th
                                                style="width: 10%; padding:3px 0px; font-size: 14px; text-align:center;border-bottom: 1px solid black;">
                                                GST
                                            </th>
                                        @elseif(App::make('possetting')->tax_type == 3)
                                            VAT
                                        @endif
                                        <th
                                            style="width: 10%; padding:3px 0px; font-size: 14px; text-align:center;border-bottom: 1px solid black;">
                                            Qty
                                        </th>
                                        <th
                                            style="width: 15%; padding:3px 0px; font-size: 14px; text-align:center;border-bottom: 1px solid black;">
                                            Rate</th>
                                        <th
                                            style="width: 20%; padding:3px 0px; font-size: 14px; text-align:right;border-bottom: 1px solid black;">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody style="width: 100%;">
                                    @foreach ($showdata->saleitem as $eachsaleitem)
                                        <tr style="width: 100%;">
                                            <td style="width: 45%; font-size: 13px; text-align:left;">
                                                {{ $eachsaleitem->product_name }} %
                                            </td>
                                            @if (App::make('possetting')->tax_type == 2)
                                                <td style="width: 10%; font-size: 13px; text-align:center;">
                                                    {{ $eachsaleitem->cgst + $eachsaleitem->sgst }}
                                                </td>
                                            @elseif(App::make('possetting')->tax_type == 3)
                                                <td style="width: 10%; font-size: 13px; text-align:center;">
                                                    {{ $eachsaleitem->vat }} %
                                                </td>
                                            @endif

                                            <td style="width: 10%; font-size: 13px; text-align:center;">
                                                {{ $eachsaleitem->quantity }}
                                            </td>
                                            <td style="width: 15%; font-size: 13px; text-align:center;">
                                                {{ $eachsaleitem->price }}
                                            </td>
                                            <td style="width: 20%; font-size: 13px; text-align:right;">
                                                {{ $eachsaleitem->grandtotal }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="border-bottom: 1px solid black;"></div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tbody style="width: 100%;">
                                    @if ($showdata->discount || $showdata->extra_charges)
                                        <tr style="width: 100%; padding-top:1px;">
                                            <td style="width: 50%; padding:0px 0px; font-size: 13px;text-align:left;">

                                            </td>
                                            <td style="width: 40%; padding:0px 0px; font-size: 13px;text-align:left;">
                                                <b>Sub Total :</b>
                                            </td>
                                            <td style="width: 10%; padding:0px 0px; font-size: 13px;text-align:right;">
                                                {{ number_format($showdata->sub_total, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($showdata->extra_charges)
                                        <tr style="width: 100%;">
                                            <td style="width: 50%; padding:0px 0px; font-size: 13px;text-align:left;">

                                            </td>
                                            <td style="width: 40%; padding:0px 0px; font-size: 13px;text-align:left;">
                                                <b>Extra Charges :</b>
                                            </td>
                                            <td style="width: 10%; padding:0px 0px; font-size: 13px;text-align:right;">
                                                {{ number_format($showdata->extra_charges, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($showdata->discount)
                                        <tr style="width: 100%;">
                                            <td style="width: 50%; padding:0px 0px; font-size: 13px;text-align:left;">

                                            </td>
                                            <td style="width: 40%; padding:0px 0px; font-size: 13px;text-align:left;">
                                                <b>Discount :</b>
                                            </td>
                                            <td style="width: 10%; padding:0px 0px; font-size: 13px;text-align:right;">
                                                {{ number_format($showdata->discount, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <table
                                style="width: 100%; border-collapse: collapse; margin-bottom:4px; padding-bottom:2px;">
                                <tbody style="width: 100%;">
                                    <tr style="width: 100%;">
                                        <td
                                            style="width: 50%; padding:0px 0px; font-size: 13px;text-align:left; margin-top:2px;">

                                        </td>
                                        <td
                                            style="width: 40%; padding:0px 0px; font-size: 13px;text-align:left; margin-top:2px;">
                                            <b>Total :</b>
                                        </td>
                                        <td
                                            style="width: 10%; padding:0px 0px; font-size: 13px;text-align:right; margin-top:2px;">
                                            {{ number_format($showdata->grandtotal, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <span>
                                <div style="border-bottom: 1px solid black;"></div>
                                <div class="text-center py-2">Thank
                                    you! Visit Again
                                </div>
                            </span>
                        </div>

                        <div class="modal-footer bg-light px-2 py-1">
                            <a href="{{ route('salepos') }}" class="btn btn-secondary">Close</a>
                            <a href="{{ route('saleprint', ['id' => $showdata->id]) }}" type="button"
                                class="btn btn-success">Print</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
