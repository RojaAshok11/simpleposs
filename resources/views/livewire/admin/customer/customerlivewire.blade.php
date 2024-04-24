<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('CUSTOMER') }}
        </x-slot>

        <x-slot name="action">
            <button wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                data-bs-toggle="modal" data-bs-target="#createoreditModal">
                {{ __('Create') }}
            </button>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('PHONE NUMBER'),
                'type' => 'sortby',
                'sortname' => 'phone',
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
            @foreach ($this->customer as $index => $eachcustomer)
                <tr>
                    <td>{{ $eachcustomer->uniqid }}</td>
                    <td class="text-center">{{ $eachcustomer->name }}</td>
                    <td>{!! $eachcustomer->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachcustomer->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachcustomer->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            {{ __('Showing') }} {{ $this->customer->firstItem() }} {{ __('to') }} {{ $this->customer->lastItem() }}
            {{ __('out of') }}
            {{ $this->customer->total() }}
            {{ __('items') }}
        </x-slot>

        <x-slot name="pagination">
            {{ $this->customer->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.customer.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.customer.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
