<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('SALE RETURN') }}
        </x-slot>

        <x-slot name="action">
            <a wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                href="{{ route('salereturncreate') }}">
                {{ __('Create') }}
            </a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('SALES RETURN ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER NAME'),
                'type' => 'sortby',
                'sortname' => 'customer_name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CUSTOMER PHONE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('SALES ID'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('RETURN DATE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('VIEW'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->salesreturn as $index => $eachsalesreturn)
                <tr>
                    <td>{{ $eachsalesreturn->uniqid }}</td>
                    <td class="text-center">{{ $eachsalesreturn->customer_name }}</td>
                    <td class="text-center">{{ $eachsalesreturn->customer_phone }}</td>
                    <td class="text-center">{{ $eachsalesreturn->sale->uniqid }}</td>
                    <td class="text-center">{{ $eachsalesreturn->created_at->format('d-m-Y') }}</td>
                    <td>
                        <button wire:click="show({{ $eachsalesreturn->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->salesreturn->firstItem() }} to {{ $this->salesreturn->lastItem() }} out of
            {{ $this->salesreturn->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->salesreturn->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Show Modal -->
    @include('livewire.admin.salereturn.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
