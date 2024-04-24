<div>
    <x-admin.layouts.admintableindex>

        <x-slot name="title">
            {{ __('Currency') }}
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
                'name' =>   __('CURRENCY ID') ,
                'type' => 'sortby',
                'sortname' => 'uniqid',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>   __('Create'),
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' => __('CURRENCY NAME') ,
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>  __('Currency') ,
                'type' => 'normal',
                'sortname' => '',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>  __('DEFAULT') ,
                'type' => 'normal',
                'sortname' => 'is_default',
            ])
            @include('helper.tablehelper.tableheader', [
                'name' =>   __('ACTIVE'),
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
            @foreach ($this->currencymaster as $index => $eachcurrencymaster)
                <tr>
                    <td>{{ $eachcurrencymaster->uniqid }}</td>
                    <td class="text-start">{{ $eachcurrencymaster->country_name }}</td>
                    <td class="text-start">{{ $eachcurrencymaster->currency_name }}</td>
                    <td>{{ $eachcurrencymaster->currency }}</td>
                    <td>{!! $eachcurrencymaster->is_default
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>{!! $eachcurrencymaster->active
                        ? '<span class="badge bg-success fs-6">Yes</span>'
                        : '<span class="badge bg-danger fs-6">No</span>' !!}
                    </td>
                    <td>
                        <button wire:click="show({{ $eachcurrencymaster->id }})" class="btn btn-sm btn-success"><i
                                class="bi bi-eye-fill"></i></button>

                        <button wire:click="edit({{ $eachcurrencymaster->id }})" class="btn btn-sm btn-primary"><i
                                class="bi bi-pencil-fill"></i></button>
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="tablerecordtotal">
            Showing {{ $this->currencymaster->firstItem() }} to {{ $this->currencymaster->lastItem() }} out of
            {{ $this->currencymaster->total() }}
            items
        </x-slot>

        <x-slot name="pagination">
            {{ $this->currencymaster->links() }}
        </x-slot>

    </x-admin.layouts.admintableindex>

    <!-- Create or Edit Modal -->
    @include('livewire.admin.settings.systemsettings.currencymaster.createoredit')

    <!-- Show Modal -->
    @include('livewire.admin.settings.systemsettings.currencymaster.show')

    <!-- Modal Action Helper -->
    @include('livewire.helper.livewiremodalhelper')

</div>
