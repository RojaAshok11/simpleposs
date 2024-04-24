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
                <h1 class="display-4 fw-bold lh-1 mb-3">Starpos Feedback</h1>
                <p class="col-lg-10 fs-5">Cloud based system can be used anywhere anytime with real time reporting,
                    graphical reports, data analytics. Take all kind of surveys and customers feedback and understand
                    their sentiments in real-time. Serving globally to hotels, restaurants, hospitals, schools, Salon,
                    Spas, boutiques, corporate organizations. Such customer feedback management platforms are useful to
                    the customer support team in handling feedback and ensuring a timely response.</p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                @livewire('admin.auth.adminloginlivewire')
            </div>
        </div>
</body>

</html>
