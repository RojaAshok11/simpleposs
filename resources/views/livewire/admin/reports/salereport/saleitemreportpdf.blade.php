<div>
    <div style="text-align:center;">
        <h3>Sales Items Report</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">NAME</th>
                <th style="border: 1px solid;">PRICE</th>
                <th style="border: 1px solid;">QUANTITY</th>
                <th style="border: 1px solid;">TOTAL</th>
                <th style="border: 1px solid;">CREATED AT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saleitemreport as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->product_name }}</td>
                    <td style="border: 1px solid;">{{ $item->price }}</td>
                    <td style="border: 1px solid;">{{ $item->quantity }}</td>
                    <td style="border: 1px solid;">{{ $item->total }}</td>
                    <td style="border: 1px solid;">{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
