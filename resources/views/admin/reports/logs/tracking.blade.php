@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminsettings') }}">{{ __('Settings') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Tracking Logs') }} </li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.reports.logs.partial', ['name' => 'trackinglogs', 'col' => 'col-sm-6'])


    @livewire('admin.reports.logs.trackinglivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminreports_sidenav',
    ])
@endsection
