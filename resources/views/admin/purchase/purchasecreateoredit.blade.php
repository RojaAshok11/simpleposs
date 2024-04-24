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

    @livewire('admin.purchase.purchasecreateoreditlivewire', ['id' => $id])
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminpurchase_sidenav',
    ])
@endsection
