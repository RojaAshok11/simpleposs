<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('Timezone') }}
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
                'name' => __('TIMEZONE ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('COUNTRY NAME'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('Timezone'),
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
            @foreach ($this->timezonemaster as $index => $eachtimezonemaster)
                <tr>
                    <td>{{ $eachtimezonemaster->uniqid }}</td>
                    <td class="text-start">{{ $eachtimezonemaster->country_name }}</td>
                    <td class="text-start">{{ $eachtimezonemaster->time_zone }}</td>
                    <td>{!! $eachtimezonemaster->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachtimezonemaster->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachtimezonemaster->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->timezonemaster->firstItem() }} to {{ $this->timezonemaster->lastItem() }} out of
            {{ $this->timezonemaster->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->timezonemaster->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.systemsettings.timezonemaster.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.systemsettings.timezonemaster.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
