<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('ADD USER') }}
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
                'name' => __('NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('PHONE'),
                'type' => 'sortby',
                'sortname' => 'phone',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('EMAIL'),
                'type' => 'normal',
                'sortname' => 'email',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('STATUS'),
                'type' => 'normal',
                'sortname' => 'is_accountactive',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CREATED BY'),
                'type' => 'normal',
                'sortname' => 'user_id',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CREATED AT'),
                'type' => 'normal',
                'sortname' => 'created_at',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('VIEW/EDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->user as $index => $eachuser)
                <tr>
                    <td>{{ $this->user->firstItem() + $index }}</td>
                    <td class="text-start">{{ $eachuser->name }}</td>
                    <td class="text-start">{{ $eachuser->phone }}</td>
                    <td class="text-start">{{ $eachuser->email }}</td>

                    <td>
                        @if ($eachuser->is_accountactive)
                            <span class="badge bg-success fs-6">Active</span>
                        @else
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge bg-danger fs-6">Inactive</span>
                            </div>
                        @endif
                    </td>


                    {{-- <td>{{ $eachuser->is_accountactive ? 'Active' : 'Inactive' }}</td> --}}
                    <td class="text-start">{{ $eachuser->createdby?->name }}</td>
                    <td>{{ $eachuser->created_at->format('d-M-Y h:i') }}</td>
                    <td>

                        <button wire:click="show({{ $eachuser->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachuser->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>

                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->user->firstItem() }} to {{ $this->user->lastItem() }} out of {{ $this->user->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->user->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.user.user.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.user.user.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
