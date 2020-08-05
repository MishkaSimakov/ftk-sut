@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">О нас</h1>

    <h2 id="contacts" class="font-weight-light mt-4">Контакты</h2>
    <div class="card mt-1">
        <div class="card-body">
            <b>Телефон</b>:
            <a class="ml-2" href="tel:+78639242821">
                +7 (8639) 24-28-21
                <i class="ml-1 fa fa-mobile-alt"></i>
            </a><br>

            <b>
                Почта
            </b>:
            <a class="ml-2" href="mailto:ftk-sut@yandex.ru">
                ftk-sut@yandex.ru
                <i class="ml-1 fa fa-envelope"></i>
            </a><br>

            <b>
                Вконтакте
            </b>:
            <a class="ml-2" href="https://vk.com/ftksut">
                Фототехнический клуб СЮТ (ФТК)
                <i class="ml-1 fab fa-vk"></i>
            </a><br>


            @auth
                <b>
                    Discord
                </b>:
                <a class="ml-2" href="https://discord.gg/KraXSVg">
                    ФТК
                    <i class="ml-1 fab fa-discord"></i>
                </a><br>
            @endauth
        </div>
    </div>


{{--    <h2 id="who" class="font-weight-light mt-4">Кто мы?</h2>--}}
{{--    <div class="card mt-1">--}}
{{--        <div class="card-body">--}}
{{--            Мы - Фототехнический клуб станции юных техников. Здесь --}}
{{--        </div>--}}
{{--    </div>--}}


    <h2 id="where" class="font-weight-light mt-4">Где мы?</h2>
    <div class="card mt-1">
        <div class="card-body">
            Мы находимся по адресу г. Волгодонск, проспект Курчатова, 47.

            <div class="embed-responsive embed-responsive-16by9 mt-2">
                <iframe
                    class="embed-responsive-item rounded w-100"
                    src="https://api-maps.yandex.ru/frame/v1/-/CCQhjZU18B?"
                    frameborder="0"
                ></iframe>
            </div>
        </div>
    </div>

@endsection

@push('side')
    <div class="card mt-2">
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li><a href="#contacts"><i class="fas fa-mobile-alt mr-2"></i>Контакты</a></li>
{{--                <li><a href="#who"><i class="fas fa-question mr-2"></i>Кто мы?</a></li>--}}
                <li><a href="#where"><i class="fas fa-map-pin mr-2"></i>Где мы?</a></li>
            </ul>
        </div>
    </div>
@endpush
