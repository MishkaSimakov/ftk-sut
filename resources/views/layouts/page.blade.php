<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head.head')
    </head>
    <body class="mb-0">
        <div id="app">
            @include('partials.header.header')

            <main style="min-height: calc(100vh - 57px - 1rem - 1.6em)">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-9">
                            @yield('content')
                        </div>

                        <div class="col-lg-3 d-none d-lg-block">
                            <div id="sidebar" style="position: relative; bottom: 0;">
                                @include('partials.side.nav')

                                @stack('side')
                            </div>
                        </div>
                        <div class="d-block d-lg-none">
                            <div>
                                @include('partials.side.small')
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include('partials.footer.footer')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>

        @stack('script')
        <script>
            $(document).ready(function () {
                let opened = false;

                $('#small_nav_toggler').click(function () {
                    $('#small_sidebar').toggle('normal');

                    setTimeout(function () {
                        opened = !opened
                    }, 100);
                });

                $(document).on('click', '*:not(#small_sidebar)', function (e) {
                    if (opened) {
                        $('#small_sidebar').hide('normal');

                        opened = false;
                    }
                });
            })
        </script>
    </body>
</html>
