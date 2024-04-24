<div>
    <div style="text-align:center;">
        <h3>Purchase Report</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">PURCHASE ID</th>
                <th style="border: 1px solid;">SUPPLIER NAME</th>
                <th style="border: 1px solid;">TOTAL ITEMS</th>
                <th style="border: 1px solid;">TOTAL</th>
                <th style="border: 1px solid;">PURCHASE DATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasereport as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->uniqid }}</td>
                    <td style="border: 1px solid;">{{ $item->supplier_name }}</td>
                    <td style="border: 1px solid;">{{ $item->total_items }}</td>
                    <td style="border: 1px solid;">{{ $item->total }}</td>
                    <td style="border: 1px solid;">{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
