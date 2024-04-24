<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('TRACKING LOGS') }}
        </x-slot>

        <x-slot name="action">
            <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminreports') }}"
                role="button">Back</a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' =>  __('S.NO'),
                'type' => 'sortby',
                'sortname' => 'created_at',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('UNIQID'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('NAME'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DETAILS'),
                'type' => 'sortby',
                'sortname' => 'trackmsg',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CREATED AT'),
                'type' => 'sortby',
                'sortname' => 'created_at',
            ])

        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->tracking as $index => $eachtracking)
                <tr>
                    <td>{{ $this->tracking->firstItem() + $index }}</td>
                    <td>
                        {{ $eachtracking->trackable->uniqid }}
                    </td>
                    <td class="text-center">
                        {{ $eachtracking->trackable->name }}
                    </td>
                    <td class="text-center"> {{ $eachtracking->trackmsg }} </td>
                    <td>{{ $eachtracking->created_at->format('d-m-Y h:i A') }}</td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->tracking->firstItem() }} to {{ $this->tracking->lastItem() }} out of
            {{ $this->tracking->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->tracking->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

</div>
