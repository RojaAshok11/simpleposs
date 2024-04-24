@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('adminreports') }}">{{ __('Settings') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Login Logs') }}</li>
    </x-admin.layouts.adminbreadcrumb>


    @include('admin.reports.logs.partial', ['name' => 'loginlogs', 'col' => 'col-sm-6'])



    @livewire('admin.reports.logs.logininfolivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminreports_sidenav',
    ])
@endsection
