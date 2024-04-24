<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('SALE HOLD') }}
        </x-slot>

        <x-slot name="action">
            <a href="{{ route('salecreateoredit') }}" type="button" class="btn btn-sm btn-primary shadow float-end mx-1">
                {{ __('Create') }} {{ __('Sale') }}
            </a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('SALE HOLD ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('REFERENCE ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER NAME'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER PHONE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('TOTAL ITEMS'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('VIEW/EDIT'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('DELETE'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->salehold as $index => $eachsalehold)
                <tr>
                    <td>{{ $eachsalehold->uniqid }}</td>
                    <td class="text-center">{{ $eachsalehold->reference_id ? $eachsalehold->reference_id : '-' }}</td>
                    <td class="text-center">{{ $eachsalehold->customer_name ? $eachsalehold->customer_name : '-' }}</td>
                    <td class="text-center">{{ $eachsalehold->customer_phone ? $eachsalehold->customer_phone : '-' }}
                    </td>
                    <td class="text-center">{{ $eachsalehold->saleholditem->count() }}</td>
                    <td>
                        <button wire:click="show({{ $eachsalehold->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                        <a href="{{ route('salecreateoredit', ['type' => 'hold', 'id' => $eachsalehold->id]) }}"
                            class="btn btn-sm btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    </td>
                    <td>
                        <button wire:click="deletemodal({{ $eachsalehold->id }})" class="btn btn-sm btn-danger"><i
                                class="bi bi-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->salehold->firstItem() }} to {{ $this->salehold->lastItem() }} out of
            {{ $this->salehold->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->salehold->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>


    <!-- Show Modal -->
    @include('livewire.admin.salehold.show')
    <!-- Delete Modal -->
    @include('livewire.admin.salehold.deletemodal')
    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('deletemodal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('deleteModal'))
                myModal.show();
            });

            Livewire.on('closedeletemodal', () => {
                alert
                var myModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'))
                myModal.hide();
            });
        });
    </script>

</div>
