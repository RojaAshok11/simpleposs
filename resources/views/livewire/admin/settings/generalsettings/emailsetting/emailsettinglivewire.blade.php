<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('EMAIL SETTINGS') }}
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
                'name' => __('PROVIDER NAME'),
                'type' => 'sortby',
                'sortname' => 'provider_name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('EMAIL NAME'),
                'type' => 'sortby',
                'sortname' => 'email_from_name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('EMAIL'),
                'type' => 'normal',
                'sortname' => 'email_from_mail',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DEFAULT'),
                'type' => 'normal',
                'sortname' => 'defaultid',
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
            @foreach ($this->emailsetting as $index => $eachemailsetting)
                <tr>
                    <td>{{ $this->emailsetting->firstItem() + $index }}</td>
                    <td>{{ $eachemailsetting->uniqid }}</td>
                    <td class="text-start">{{ $eachemailsetting->provider_name }}</td>
                    <td>{{ $eachemailsetting->email_from_name }}</td>
                    <td>{{ $eachemailsetting->email_from_mail }}</td>
                    <td>{!! $eachemailsetting->is_default
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>{!! $eachemailsetting->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachemailsetting->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                        <button wire:click="edit({{ $eachemailsetting->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->emailsetting->firstItem() }} to {{ $this->emailsetting->lastItem() }} out of
            {{ $this->emailsetting->total() }} items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->emailsetting->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.generalsettings.emailsetting.createoredit')
    <!-- Show Modal -->
    @include('livewire.admin.settings.generalsettings.emailsetting.show')
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
