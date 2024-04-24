<div>
    <div style="text-align:center;">
        <h3>{{ __('EXPENSE REPORTS') }}</h3>
    </div>
    <table style="border: 1px solid; border-collapse: collapse; width:100%; font-size:10px;">
        <thead>
            <tr>
                <th style="border: 1px solid;">S.NO</th>
                <th style="border: 1px solid;">EXPENSE FOR</th>
                <th style="border: 1px solid;">COMPANY / PERSON / SERVICE NAME</th>
                <th style="border: 1px solid;">AMOUNT</th>
                <th style="border: 1px solid;">EXPENSE DATE</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($expensereport as $key => $item)
                <tr>
                    <td style="border: 1px solid;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid;">{{ $item->expensecategory->name }}</td>
                    <td style="border: 1px solid;">{{ $item->name ? $item->name : '' }}</td>
                    <td style="border: 1px solid;">{{ $item->amount }}</td>
                    <td style="border: 1px solid;">{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
