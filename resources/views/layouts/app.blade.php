<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favion.ico -->
{{--        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">--}}
{{--        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">--}}
{{--        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">--}}
{{--        <link rel="manifest" href="/site.webmanifest">--}}
{{--        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">--}}
{{--        <meta name="msapplication-TileColor" content="#da532c">--}}
{{--        <meta name="theme-color" content="#ffffff">--}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Laravel routes and csrf token -->
    <script>
        window.Laravel = {!! json_encode([
                'tinymce_api_key' => "hnviucqus9116ko1nycfet8r4rlvw0akh6w27lord3o9nz15",
                'csrfToken' => csrf_token(),
                'routes' => collect(\Illuminate\Support\Facades\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
            ]) !!}
    </script>

    <!-- Some SEO -->
    <title>@isset($title) {{ $title }} @else @yield('title') @endisset - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', 'Сайт Фототехнического клуба СЮТ. Здесь есть всё, чтобы быть активным кружковцем и не сачковать! Новости, расписание, статьи, рейтинг - и всё это на одном сайте.')">
    <meta name="keywords" content="@yield('keywords', 'ФТК СЮТ, Фототехнический клуб, ФТК, Дополнительное образование')"/>
    <meta name="robots" content="@yield('robots', 'index, follow')"/>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @if(!isset($includeLivewire) || $includeLivewire)
        @livewireStyles
    @endif
</head>
<body>
<div id="app">
    @include('partials.header.header')

    @yield('messages')

    @yield('masthead')

    <main class="py-4 container">
        @yield('content')
    </main>
</div>

@stack('scripts')

@if(!isset($includeLivewire) || $includeLivewire)
    @livewireScripts
@endif
</body>
</html>
