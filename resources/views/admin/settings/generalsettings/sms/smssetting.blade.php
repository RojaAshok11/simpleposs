@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('GENERAL SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminsettings') }}">{{ __('Settings') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('SMS Setting') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.settings.generalsettings.partial', ['name' => 'sms', 'col' => 'col-sm-6'])

    @livewire('admin.settings.generalsettings.smssetting.smssettinglivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsettings_sidenav',
    ])
@endsection
