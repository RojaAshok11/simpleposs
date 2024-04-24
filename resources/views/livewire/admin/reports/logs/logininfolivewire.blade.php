<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('LOGIN LOGS') }}
        </x-slot>

        <x-slot name="action">
            <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminreports') }}"
                role="button">{{ __('Back') }}</a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('S.NO'),
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
                'name' => __('DEVICE / BROWSER / PLATFORM / TYPE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('STATUS'),
                'type' => 'sortby',
                'sortname' => 'login_status',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>  __('CREATED AT'),
                'type' => 'sortby',
                'sortname' => 'created_at',
            ])

        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->logininfo as $index => $eachlogininfo)
                <tr>
                    <td>{{ $this->logininfo->firstItem() + $index }}</td>
                    <td>
                        {{ $eachlogininfo->logininfoable->uniqid }}
                    </td>
                    <td class="text-start">
                        {{ $eachlogininfo->logininfoable->name }}
                    </td>
                    <td> {{ $eachlogininfo->device }} / {{ $eachlogininfo->browser }} /
                        {{ $eachlogininfo->platform }} / {{ $eachlogininfo->type }}
                    </td>
                    <td>{!! $eachlogininfo->login_status
                        ? '<span class="badge bg-success fs-6">Success</span>'
                        : '<span class="badge bg-danger fs-6">Fail</span>' !!}
                    </td>
                    <td>{{ $eachlogininfo->created_at->format('d-M-Y h:i') }}</td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->logininfo->firstItem() }} to {{ $this->logininfo->lastItem() }} out of
            {{ $this->logininfo->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->logininfo->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

</div>
