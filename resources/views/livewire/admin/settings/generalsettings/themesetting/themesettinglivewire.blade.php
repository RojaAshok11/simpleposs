<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('THEME SETTING') }} 
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
                'name' => __('NAME'),
                'type' => 'sortby',
                'sortname' => 'theme_name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DEFAULT'),
                'type' => 'normal',
                'sortname' => 'is_default',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('ACTIVE'),
                'type' => 'normal',
                'sortname' => 'active',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('VIEW/EDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->themesetting as $index => $eachthemesetting)
                <tr>
                    <td>{{ $this->themesetting->firstItem() + $index }}</td>
                    <td>{{ $eachthemesetting->uniqid }}</td>
                    <td class="text-start">{{ $eachthemesetting->theme_name }}</td>
                    <td>{!! $eachthemesetting->is_default
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>{!! $eachthemesetting->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachthemesetting->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                        <button wire:click="edit({{ $eachthemesetting->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->themesetting->firstItem() }} to {{ $this->themesetting->lastItem() }} out of
            {{ $this->themesetting->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->themesetting->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.generalsettings.themesetting.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.generalsettings.themesetting.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
