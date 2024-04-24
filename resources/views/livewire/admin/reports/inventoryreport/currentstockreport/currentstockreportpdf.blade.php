<div>
    <div style="text-align:center;">
        <h3>Current Stock Report</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">PRODUCT ID</th>
                <th style="border: 1px solid;">PRODUCT NAME</th>
                <th style="border: 1px solid;">SKU</th>
                <th style="border: 1px solid;">CURRENT STOCK</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($currentstock as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->uniqid }}</td>
                    <td style="border: 1px solid;">{{ $item->name }}</td>
                    <td style="border: 1px solid;">{{ $item->sku }}</td>
                    <td style="border: 1px solid;">{{ $item->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
