<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> {{ config('app.name', '8Queens') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="bg-white">
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">
                    {{ App::make('companysetting') ? App::make('companysetting')->companyfullname : 'POS' }}
                </h1>
                <p class="col-lg-10 fs-5">
                    {{ App::make('companysetting') ? App::make('companysetting')->companyfullname : 'POS' }}
                    is an easy-to-use, convenient, secure solution for your retail
                    business, enabling you to manage all key functions such as billing, inventory and much more.
                </p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                @livewire('admin.auth.adminloginlivewire')
            </div>
        </div>
</body>

</html>
