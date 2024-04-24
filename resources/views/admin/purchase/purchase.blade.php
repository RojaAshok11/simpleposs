@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('PURCHASE') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Purchase') }}</li>
    </x-admin.layouts.adminbreadcrumb>
    @include('admin.purchase.partial', [
        'name' => 'adminpurchase',
        'col' => 'col-sm-6',
    ])
    @livewire('admin.purchase.purchaselivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminpurchase_sidenav',
    ])
@endsection
