<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Сайт Фототехнического клуба СЮТ">
    <meta name="keywords" content="ФТК, ФТК-СЮТ, СЮТ, Робототехника, Волгодонск">
    <meta name="author" content="Симаков Михаил">
    <meta name="robots" content="index,follow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ФТК СЮТ</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Icons --}}
    <script src="https://kit.fontawesome.com/799166843b.js" crossorigin="anonymous"></script>

    {{--  text editor  --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    {{--  lity for lightboxes  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">
    @include('partials.header.header')

    <main class="main-container">
        @yield('content')
    </main>

    @include('partials.footer.footer')
</div>

@stack('script')

</body>
</html>
