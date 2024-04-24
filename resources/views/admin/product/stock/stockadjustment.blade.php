@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('STOCK ADJUSTMENT') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Stock Adjustment') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.product.partial', [
        'name' => 'adminstockadjustment',
        'col' => 'col-sm-6',
    ])

    @livewire('admin.product.stock.stockadjustmentlivewire')
@endsection

@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminproduct_sidenav',
    ])
@endsection
