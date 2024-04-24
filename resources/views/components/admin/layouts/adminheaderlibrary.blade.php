@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link rel="stylesheet"
    href="{{ asset('css/' . (App::make('themesetting') ? App::make('themesetting')->path : 'theme/bluetheme.css')) }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@section('headSection')
@show
