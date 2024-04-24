@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('SALE RETURN') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminsalereturn') }}">{{ __('Sale Return') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create Sale Return') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @livewire('admin.salereturn.createsalereturnlivewire', ['id' => $id])
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminsale_sidenav',
    ])
@endsection
