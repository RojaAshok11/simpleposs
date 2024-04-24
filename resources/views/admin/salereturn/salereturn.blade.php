@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SALE RETURN') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Sale Return') }}</li>
    </x-admin.layouts.adminbreadcrumb>
    @include('admin.sale.partial', [
        'name' => 'adminsalereturn',
        'col' => 'col-sm-8',
    ])
    @livewire('admin.salereturn.salereturnlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsale_sidenav',
    ])
@endsection
