@extends('components.admin.layouts.adminapp')
@section('headSection')
@endsection

@section('adminnavbar')
    <x-admin.layouts.adminnavbar modulename="{{ __('PURCHASE RETURN') }}" />
@endsection

@section('main-content')
    <x-admin.layouts.adminbreadcrumb>
        <li class="breadcrumb-item"><a class="text-decoration-none"
                href="{{ route('adminpurchasereturn') }}">{{ __('Purchase Return') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Create Purchase Return') }}</li>
    </x-admin.layouts.adminbreadcrumb>

    @livewire('admin.purchasereturn.createpurchasereturnlivewire')
@endsection
@section('footerSection')
    @include('helper.sidenavhelper.sidenavactive', [
        'type' => 1,
        'nameone' => '#adminpurchase_sidenav',
    ])
@endsection
