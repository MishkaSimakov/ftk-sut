<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="Сайт Фототехнического клуба СЮТ">
        <meta name="keywords" content="ФТК, ФТК-СЮТ, СЮТ, Робототехника, Волгодонск">
        <meta name="author" content="Симаков Михаил">
        <meta name="robots" content="index,follow">

{{--        vk snippet data --}}
        <meta property="og:title" content="{{ isset($title) ? $title . ' | ФТК СЮТ' : 'ФТК СЮТ' }}"/>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ФТК СЮТ</title>

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'user' => [
                    'id' => Auth::check() ? Auth::user()->id : null,
                    'name' => Auth::check() ? Auth::user()->name : null,
                ]
            ]) !!}
        </script>

{{--        TODO: install all this libraries to local --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        {{--  lity for lightboxes  --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

        {{--    datatables --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

        @if (env("APP_ENV") !== 'local')
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript" >
                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                ym(57657454, "init", {
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/57657454" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        @endif

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="mb-0">
        <div id="app">
            @include('partials.header.header')

            <main>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            @yield('content')
                        </div>

                        <div class="col-md-4">
                            <div id="sidebar" style="position: relative; bottom: 0;">
                                @include('partials.side.nav')

                                @stack('side')

                                <div id="side_bottom"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

{{--            @include('partials.footer.footer')--}}
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        @stack('script')
        <script>
            let lastScrollTop = 0;
            $(window).scroll(function(event){
                let st = $(this).scrollTop();
                let sidebar = $('#sidebar');
                let bottom = $('#side_bottom');

                if (st > lastScrollTop){
                    if (bottom.position().top - sidebar.height() / 2 < $(this).scrollTop()) {
                        sidebar.css('bottom', Math.min(0, -$(this).scrollTop() + sidebar.height() / 2) + 'px');
                    }
                } else {
                    if (sidebar.position().top > $(this).scrollTop()) {
                        sidebar.css('bottom', Math.min(0, -$(this).scrollTop()) + 'px');
                    }
                }
                lastScrollTop = st;
            });
        </script>
    </body>
</html>
