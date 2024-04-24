<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('EXPENSE') }}
        </x-slot>

        <x-slot name="action">
            <button wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                data-bs-toggle="modal" data-bs-target="#createoreditModal">
                {{ __('Create') }}
            </button>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('EXPENSE ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('COMPANY/ PERSON/ SERVICE NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
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
            @foreach ($this->expense as $index => $eachexpense)
                <tr>
                    <td>{{ $eachexpense->uniqid }}</td>
                    <td class="text-center">{{ $eachexpense->name }}</td>
                    <td>{!! $eachexpense->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachexpense->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachexpense->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->expense->firstItem() }} to {{ $this->expense->lastItem() }} out of
            {{ $this->expense->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->expense->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.expense.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.expense.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
