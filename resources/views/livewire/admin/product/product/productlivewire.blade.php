<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('PRODUCT') }}
        </x-slot>

        <x-slot name="action">
            <button wire:click="create" type="button" class="btn btn-sm btn-primary shadow float-end mx-1"
                data-bs-toggle="modal" data-bs-target="#createoreditModal">
                {{ __('Create') }}
            </button>
        </x-slot>

        <x-slot name="tableheader">
            @include('helper.tablehelper.tableheader', [
                'name' => __('PRODUCT ID'),
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('PRODUCT NAME'),
                'type' => 'sortby',
                'sortname' => 'name',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('STOCK'),
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
            @include('helper.tablehelper.tableheader', [
                'name' => __('BARCODE'),
                'type' => 'normal',
                'sortname' => '',
            ])
        </x-slot>

        <x-slot name="tablebody">
            @foreach ($this->product as $index => $eachproduct)
                <tr>
                    <td>{{ $eachproduct->uniqid }}</td>
                    <td class="text-center">{{ $eachproduct->name }}</td>
                    <td class="text-center">{{ $eachproduct->stock }}</td>
                    <td>
                        @if ($eachproduct->active)
                            <span class="badge bg-success fs-6"> {{ __('Yes') }}</span>
                        @else
                            <span class="badge bg-danger fs-6">{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>
                        <button wire:click="show({{ $eachproduct->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachproduct->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                    <td>
                        <button wire:click="showbarcode({{ $eachproduct->id }})" class="btn btn-sm btn-secondary"><i
                                class="bi bi-upc-scan"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->product->firstItem() }} to {{ $this->product->lastItem() }} out of
            {{ $this->product->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->product->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.product.product.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.product.product.show')

    <!-- Show Barcode Modal -->
    @include('livewire.admin.product.product.showbarcode')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('printbarcodemodal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('printbarcodemodal'))
                myModal.show();
            });

            Livewire.on('printbarcode', (data) => {
                var url = "{{ url('/') }}" + "/admin/printbarcode/" + data.count + "/" + data.uniqid;
                window.open(url);
            });
        });
    </script>
</div>
