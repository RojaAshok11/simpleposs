@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('CUSTOMER') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Customer') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @livewire('admin.customer.customerlivewire')
@endsection

@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#admincustomer_sidenav',
    ])
@endsection
