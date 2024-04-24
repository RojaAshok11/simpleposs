<div>
    <div style="text-align:center;">
        <h3>Sales Report</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">SALES ID</th>
                <th style="border: 1px solid;">NAME</th>
                <th style="border: 1px solid;">PAYMENT MODE</th>
                <th style="border: 1px solid;">TOTAL ITEMS</th>
                <th style="border: 1px solid;">PROFIT</th>
                <th style="border: 1px solid;">TOTAL</th>
                <th style="border: 1px solid;">CREATED AT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salereport as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->uniqid }}</td>
                    <td style="border: 1px solid;">{{ $item->customer?->name }}</td>
                    <td style="border: 1px solid;">{{ $item->mode ? Config::get('archive.mode')[$item->mode] : '-' }}
                    </td>
                    <td style="border: 1px solid;">{{ $item->total_items }}</td>
                    <td style="border: 1px solid;">{{ $item->grandtotal - $item->sub_total }}</td>
                    <td style="border: 1px solid;">{{ $item->total }}</td>
                    <td style="border: 1px solid;">{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
