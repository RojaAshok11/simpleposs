@extends('components.admin.layouts.adminapp')
@section('headSection')

@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('PRODUCT') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Product') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.product.partial', [
        'name' => 'adminproduct',
        'col' => 'col-sm-6',
    ])

    @livewire('admin.product.product.productlivewire')
@endsection

@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminproduct_sidenav',
    ])
@endsection
