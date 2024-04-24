@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('REPORTS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">
            {{ __('Reports') }}
        </li>
    </x-admin.layouts.adminbreadcrumb>

    <div class="p-2">

        @include('admin.reports.reports.logreports')
        @include('admin.reports.reports.salesreports')
        @include('admin.reports.reports.purchasereports')
        @include('admin.reports.reports.inventoryreports')
        @include('admin.reports.reports.expensereports')



    </div>
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminreports_sidenav',
    ])
@endsection
