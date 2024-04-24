@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('USER SETTINGS') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminsettings') }}">{{ __('Settings') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('User') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.settings.user.partial', ['name' => 'adduser', 'col' => 'col-sm-6'])

    @livewire('admin.settings.user.user.userlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsettings_sidenav',
    ])
@endsection
