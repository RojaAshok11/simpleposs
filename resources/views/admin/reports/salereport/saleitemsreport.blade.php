@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('REPORTS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('adminreports') }}">{{ __('Reports') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Sale Items Reports') }} </li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.reports.salereport.partial', ['name' => 'saleitemsreport', 'col' => 'col-sm-6'])


    @livewire('admin.reports.salereport.saleitemsreportlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminreports_sidenav',
    ])
@endsection
