<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="margin: auto;padding:auto;" onafterprint="myFunction()">
    <div style="margin-top:0;padding:2%;margin-bottom:0" id="printcontent">
        <div style=" text-align: center;font-size: 12px;">
            <b>{{ App::make('companysetting') ? App::make('companysetting')->companyfullname : 'POS' }}</b>
        </div>
        <div style="text-align: center;font-size: 10px; border-bottom: 1px solid black; margin-bottom:2px">
            {{ App::make('companysetting') ? App::make('companysetting')->address : '' }}<br>
            Ph : {{ App::make('companysetting') ? App::make('companysetting')->phone : '' }}
            @if (App::make('companysetting')?->alternate_phone)
                ,
                {{ App::make('companysetting') ? App::make('companysetting')->alternate_phone : '' }}
            @endif
        </div>

        <div style="display:flex; justify-content:space-between;font-size: 10px; margin-top:2px">
            <div>Bill No: <b>{{ $sale->uniqid }}</b></div>
            <div> Total Items: <b>{{ $sale->total_items }}</b>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:2px;font-size: 10px">
            <div>Date: <b>{{ $sale->created_at->format('d/M/Y') }}</b></div>
            <div>Time: <b>{{ $sale->created_at->format('H:i:s') }}</b></div>
        </div>
        @if ($sale->customer_id)
            <div style="display:flex; justify-content:space-between; margin-bottom:2px;font-size: 10px">
                <div>Name: <b>{{ $sale->customer_name }}</b></div>
                <div>Phone: <b>{{ $sale->customer_phone }}</b></div>
            </div>
        @endif
        <div style="display:flex; justify-content:space-between; margin-bottom:2px;font-size: 10px">
            <div>Mode: <b>{{ $sale->mode ? Config::get('archive.mode')[$sale->mode] : null }}</b></div>
        </div>

        <table style="width: 100%;margin-top:0px; border-collapse: collapse; margin-bottom:3px;">
            <thead>
                <tr style="margin-bottom: 1px; border-top: 1px solid black;">
                    <th
                        style="width: 55%; padding:3px 0px; font-size: 10px;text-align:left;border-bottom: 1px solid black;">
                        Item Name</th>
                    <th
                        style="width: 10%; padding:3px 0px; font-size: 10px;text-align:center;border-bottom: 1px solid black;">
                        Qty</th>
                    <th
                        style="width: 15%; padding:3px 0px; font-size: 10px;text-align:center;border-bottom: 1px solid black;">
                        Rate</th>
                    <th
                        style="width: 20%; padding:3px 0px; font-size: 10px;text-align:right;border-bottom: 1px solid black;">
                        Amount</th>
                </tr>
            </thead>
            <tbody style="width: 100%;">
                @foreach ($sale->saleitem as $eachsaleitem)
                    <tr style="width: 100%;">
                        <td style="width: 55%; padding:0px; font-size: 10px;text-align:left;">
                            {{ $eachsaleitem->product_name }}
                        </td>
                        <td style="width: 10%; padding:0px; font-size: 10px;text-align:center;">
                            {{ $eachsaleitem->quantity }}
                        </td>
                        <td style="width: 15%; padding:0px; font-size: 10px;text-align:center;">
                            {{ number_format($eachsaleitem->price, 2) }}
                        </td>
                        <td style="width: 20%; padding:0px; font-size: 10px;text-align:right;">
                            {{ number_format($eachsaleitem->total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <span>
            <table style="width: 100%; border-collapse: collapse; border-top: 1px solid black;">
                <tbody style="width: 100%;">
                    @if ($sale->discount || $sale->extra_charges)
                        <tr style="width: 100%; padding-top:1px;">
                            <td style="width: 50%; padding:0px 0px; font-size: 10px;text-align:left;">

                            </td>
                            <td style="width: 40%; padding:0px 0px; font-size: 10px;text-align:left;">
                                <b>Sub Total :</b>
                            </td>
                            <td style="width: 10%; padding:0px 0px; font-size: 10px;text-align:right;">
                                {{ number_format($sale->sub_total, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if ($sale->extra_charges)
                        <tr style="width: 100%;">
                            <td style="width: 50%; padding:0px 0px; font-size: 10px;text-align:left;">

                            </td>
                            <td style="width: 40%; padding:0px 0px; font-size: 10px;text-align:left;">
                                <b>Extra Charges :</b>
                            </td>
                            <td style="width: 10%; padding:0px 0px; font-size: 10px;text-align:right;">
                                {{ number_format($sale->extra_charges, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if ($sale->discount)
                        <tr style="width: 100%;">
                            <td style="width: 50%; padding:0px 0px; font-size: 10px;text-align:left;">

                            </td>
                            <td style="width: 40%; padding:0px 0px; font-size: 10px;text-align:left;">
                                <b>Discount :</b>
                            </td>
                            <td style="width: 10%; padding:0px 0px; font-size: 10px;text-align:right;">
                                {{ number_format($sale->discount, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <table style="width: 100%; border-collapse: collapse; margin-bottom:4px; padding-bottom:2px;">
                <tbody style="width: 100%;">
                    <tr style="width: 100%; border-top: 1px solid black; ">
                        <td style="width: 50%; padding:0px 0px; font-size: 10px;text-align:left; margin-top:2px;">

                        </td>
                        <td style="width: 40%; padding:0px 0px; font-size: 10px;text-align:left; margin-top:2px;">
                            <b>Total :</b>
                        </td>
                        <td style="width: 10%; padding:0px 0px; font-size: 10px;text-align:right; margin-top:2px;">
                            {{ number_format($sale->total, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </span>
        <span>
            <div style=" text-align: center;font-size: 10px; border-top: 1px solid black; ">Thank you! Visit Again
            </div>
        </span>
    </div>
    <script>
        const x = () => {
            window.print();
        };
        x();

        function myFunction() {
            var url = "{{ url('/') }}" + "/admin/salepos";
            window.location.href = url;
        }
    </script>
</body>

</html>
