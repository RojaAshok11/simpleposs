<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('SUPPLIER') }}
        </x-slot>

        <x-slot name="action">
            <button wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                data-bs-toggle="modal" data-bs-target="#createoreditModal">
                {{ __('Create') }}
            </button>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('SUPPLIER ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('COMPANY NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('COMPANY PHONE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CONTACT PERSON'),
                'type' => 'sortby',
                'sortname' => 'cpname',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CONTACT PERSON PHONE'),
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
            @foreach ($this->supplier as $index => $eachsupplier)
                <tr>
                    <td>{{ $eachsupplier->uniqid }}</td>
                    <td class="text-center">{{ $eachsupplier->name }}</td>
                    <td class="text-center">{{ $eachsupplier->phone }}</td>
                    <td class="text-center">{{ $eachsupplier->cpname }}</td>
                    <td class="text-center">{{ $eachsupplier->cpphone }}</td>
                    <td>
                        @if ($eachsupplier->active)
                            <span class="badge bg-success fs-6"> {{ __('Yes') }}</span>
                        @else
                            <span class="badge bg-danger fs-6">{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>
                        <button wire:click="show({{ $eachsupplier->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachsupplier->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->supplier->firstItem() }} to {{ $this->supplier->lastItem() }} out of
            {{ $this->supplier->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->supplier->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.supplier.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.supplier.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
