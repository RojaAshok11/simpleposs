@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SALE') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Sale') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @livewire('admin.sale.salecreateoreditlivewire', ['id' => $id, 'type' => $type])
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsale_sidenav',
    ])
@endsection
