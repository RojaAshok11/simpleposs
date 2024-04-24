<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('STOCK ADJUSTMENT') }}
        </x-slot>

        <x-slot name="action">
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('STOCK ADJUSTMENT ID'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('SKU'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CURRENT STOCK'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('HISTORY'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('MANAGEMENT'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->stock as $index => $eachstock)
                <tr>
                    <td>{{ $eachstock->uniqid }}</td>
                    <td class="text-center">{{ $eachstock->name }}</td>
                    <td class="text-center">{{ $eachstock->sku }}</td>
                    <td class="text-center">{{ $eachstock->stock }}</td>
                    <td><a href="{{ route('stockhistory', ['id' => $eachstock->id]) }}" class="btn btn-sm btn-warning"
                            role="button"><i class="bi bi-clock-history"></i></a></td>
                    <td>
                        <button wire:click="edit({{ $eachstock->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-file-earmark-bar-graph"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->stock->firstItem() }} to {{ $this->stock->lastItem() }} out of
            {{ $this->stock->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->stock->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.product.stock.createoredit')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
