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
        <li class="breadcrumb-item active" aria-current="page"> {{ __('Change Password') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @include('admin.settings.user.partial', ['name' => 'changepassword', 'col' => 'col-sm-6'])

    <div class="card shadow-sm">
        <div class="card-header text-white theme_bg_color">
            <div class="d-flex flex-row bd-highlight">
                <div class="flex-grow-1 bd-highlight mt-1"><span class="h5">{{ __('CHANGE PASSWORD') }}</span>
                </div>
                <div class="bd-highlight">
                    <a class="btn btn-sm btn-secondary shadow float-end mx-1" href="{{ route('adminsettings') }}"
                        role="button">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body row g-3 mb-5">
            @livewire('admin.settings.user.changepassword.userchangepasswordlivewire')
        </div>
    </div>
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsettings_sidenav',
    ])
@endsection
