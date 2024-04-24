<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-admin.layouts.adminheader />
    <x-admin.layouts.adminheaderlibrary />
</head>

<body style="background: #f1f5f9;">
    <div class="{{ session('adminsessiontoggled') }}" id="wrapper">
        @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
        <!-- Sidebar -->
        <x-admin.layouts.adminsidebar />
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="navbar-wrapper">
            @section('adminnavbar')
            @show
        </div>
        <section id="content-wrapper">
            @section('main-content')
            @show
        </section>
    </div>
    <!-- /#page-content-wrapper -->
    <x-admin.layouts.adminfooterlibrary />

</body>

</html>
