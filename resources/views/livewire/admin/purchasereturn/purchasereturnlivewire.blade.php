<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('PURCHASE RETURN') }}
        </x-slot>

        <x-slot name="action">
            <a wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                href="{{ route('purchasereturncreate') }}">
                {{ __('Create') }}
            </a>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('PURCHASE RETURN ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('SUPPLIER NAME'),
                'type' => 'sortby',
                'sortname' => 'customer_name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('SUPPLIER PHONE'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('PURCHASE ID'),
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
            @foreach ($this->purchasereturn as $index => $eachpurchasereturn)
                <tr>
                    <td>{{ $eachpurchasereturn->uniqid }}</td>
                    <td class="text-center">{{ $eachpurchasereturn->supplier_name }}</td>
                    <td class="text-center">{{ $eachpurchasereturn->supplier_phone }}</td>
                    <td class="text-center">{{ $eachpurchasereturn->purchase->uniqid }}</td>
                    <td class="text-center">{{ $eachpurchasereturn->created_at->format('d-m-Y') }}</td>
                    <td>
                        <button wire:click="show({{ $eachpurchasereturn->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->purchasereturn->firstItem() }} to {{ $this->purchasereturn->lastItem() }} out of
            {{ $this->purchasereturn->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->purchasereturn->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Show Modal -->
    @include('livewire.admin.purchasereturn.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
</div>
