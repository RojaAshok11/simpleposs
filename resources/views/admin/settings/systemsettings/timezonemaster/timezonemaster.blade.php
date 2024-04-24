@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SYSTEM SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminsettings') }}">{{ __('Settings') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Timezone') }}</li>
    </x-admin.layouts.adminbreadcrumb>
    @include('admin.settings.systemsettings.partial', ['name' => 'timezonemaster', 'col' => 'col-sm-6'])

    @livewire('admin.settings.systemsettings.timezonemaster.timezonemasterlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsettings_sidenav',
    ])
@endsection
