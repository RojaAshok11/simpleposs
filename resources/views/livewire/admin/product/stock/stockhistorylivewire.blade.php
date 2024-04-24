<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('STOCK HISTORY') }}
        </x-slot>

        <x-slot name="action">
            <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminstockadjustment') }}"
                role="button">{{ __('Back') }}</a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('S.NO'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CREDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DEBIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('BALANCE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('ADJUSTMENT'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DATE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CREATED BY'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->stockhistory as $index => $eachstockhistory)
                <tr class="{{ $eachstockhistory->c_or_d == 'C' ? 'table-success' : 'table-danger' }}">
                    <td class="text-center">{{ $this->stockhistory->firstItem() + $index }}</td>
                    <td class="text-center">{{ $eachstockhistory->credit }}</td>
                    <td class="text-center">{{ $eachstockhistory->debit }}</td>
                    <td class="text-center">{{ $eachstockhistory->balance }}</td>
                    <td class="text-center">{{ $eachstockhistory->is_adjustment }}</td>
                    <td class="text-center">{{ $eachstockhistory->created_at->format('d-m-Y h:i A') }}</td>
                    <td class="text-center">{{ $eachstockhistory->user->name }}</td>
                </tr>
            @endforeach
        </x-slot>
        {{-- #d1e7dd --}}
        <x-slot name="tablerecordtotal">
            Showing {{ $this->stockhistory->firstItem() }} to {{ $this->stockhistory->lastItem() }} out of
            {{ $this->stockhistory->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->stockhistory->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

</div>
