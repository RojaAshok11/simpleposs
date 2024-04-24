<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('DEFAULT') }} 
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
                'name' => __('EMAIL'),
                'type' => 'sortby',
                'sortname' => 'email',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DEFAULT'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('ACTIVE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>  __('VIEW/EDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->fcmsetting as $index => $eachfcmsetting)
                <tr>
                    <td>{{ $this->fcmsetting->firstItem() + $index }}</td>
                    <td>{{ $eachfcmsetting->uniqid }}</td>
                    <td class="text-start">{{ $eachfcmsetting->email }}</td>
                    <td>{!! $eachfcmsetting->is_default
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>{!! $eachfcmsetting->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachfcmsetting->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                        <button wire:click="edit({{ $eachfcmsetting->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->fcmsetting->firstItem() }} to {{ $this->fcmsetting->lastItem() }} out of
            {{ $this->fcmsetting->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->fcmsetting->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.generalsettings.fcmsetting.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.generalsettings.fcmsetting.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
