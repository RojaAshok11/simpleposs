<div>
    <div style="text-align:center;">
        <h3>Stock Credit / Debit Reports</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">NAME</th>
                <th style="border: 1px solid;">CREDIT</th>
                <th style="border: 1px solid;">DEBIT</th>
                <th style="border: 1px solid;">BALANCE</th>
                <th style="border: 1px solid;">TYPE</th>
                <th style="border: 1px solid;">DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockreport as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->product->name }}</td>
                    <td style="border: 1px solid;">{{ $item->credit }}</td>
                    <td style="border: 1px solid;">{{ $item->debit }}</td>
                    <td style="border: 1px solid;">{{ $item->balance }}</td>
                    <td style="border: 1px solid;">
                        @switch($item->stockcdable_type)
                            @case('App\Models\Admin\Product\Product')
                                Product
                            @break

                            @case('App\Models\Admin\Purchase\Purchase')
                                Purchase
                            @break

                            @case('App\Models\Admin\Sale\Sale')
                                Sale
                            @break

                            @default
                                -
                        @endswitch

                    </td>
                    <td style="border: 1px solid;">{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
