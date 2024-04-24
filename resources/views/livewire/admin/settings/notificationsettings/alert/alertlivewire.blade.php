<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('Alert') }} 
        </x-slot>

        <x-slot name="action">
            <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminsettings') }}"
                role="button">{{ __('Back') }}</a>
            <button wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                data-bs-toggle="modal" data-bs-target="#createoreditModal">
                {{ __('Create') }}
            </button>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('S.NO'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('UNIQID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('ALERT MESSAGE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('ACTIVE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('VIEW/EDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->alert as $index => $eachalert)
                <tr>
                    <td>{{ $this->alert->firstItem() + $index }}</td>
                    <td>{{ $eachalert->uniqid }}</td>
                    <td class="text-center">{{ $eachalert->alertmessage }}</td>
                    <td>{!! $eachalert->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachalert->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachalert->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->alert->firstItem() }} to {{ $this->alert->lastItem() }} out of
            {{ $this->alert->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->alert->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.notificationsettings.alert.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.notificationsettings.alert.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
