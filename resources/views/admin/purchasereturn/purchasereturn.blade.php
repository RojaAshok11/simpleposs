@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('PURCHASE RETURN') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Purchase Return') }}</li>
    </x-admin.layouts.adminbreadcrumb>
    @include('admin.purchase.partial', [
        'name' => 'adminpurchasereturn',
        'col' => 'col-sm-6',
    ])
    @livewire('admin.purchasereturn.purchasereturnlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminpurchase_sidenav',
    ])
@endsection
