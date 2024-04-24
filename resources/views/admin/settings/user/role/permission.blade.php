@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="SETTINGS" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('adminsettings') }}">Settings</a></li>
        <li class="breadcrumb-item active" aria-current="page">Roles & Permission</li>
    </x-admin.layouts.adminbreadcrumb>

    @livewire('admin.settings.user.role.permissionlivewire', ['id' => $id])
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#setting_sidenav',
    ])
    @include('helper.modalhelper.livewiremodal')
@endsection
