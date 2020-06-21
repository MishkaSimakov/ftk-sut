<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head.head')
    </head>
    <body class="mb-0 p-0">
        <div id="app">
            <main>
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>

        @stack('script')
    </body>
</html>
