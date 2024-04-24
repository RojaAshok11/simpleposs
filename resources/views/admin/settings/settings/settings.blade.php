@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item active" aria-current="page">
            {{ __('Settings') }}
        </li>
    </x-admin.layouts.adminbreadcrumb>

    <div class="p-2">
        @include('admin.settings.settings.mastersettings')
        @include('admin.settings.settings.usersettings')
        @include('admin.settings.settings.generalsettings')
        @include('admin.settings.settings.systemsettings')
        @include('admin.settings.settings.possettings')
        @include('admin.settings.settings.locationsettings')
        @include('admin.settings.settings.supportsettings')
        @include('admin.settings.settings.notificationsettings')
    </div>
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsettings_sidenav',
    ])
@endsection
