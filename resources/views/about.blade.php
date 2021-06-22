@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'О нас')
@section('description', 'Контакты, местоположение и история ФТК.')
@section('robots', 'index, follow')

@section('content')
    <h1 class="text-center mb-4">О нас</h1>

    <p>
        <b>Фототехнический клуб (ФТК)</b> - клуб в Волгодонске, в котором функционируют множество кружков:
        робототехника, электроника, рукоделие и т.д.
        Сайт, на котором вы находитесь, сделан для более удобного доступа к информации о клубе: статьям, новостям и
        мероприятиям.
    </p>

    <p>
        Более подробно о клубе и его многолетней истории вы можете узнать, посмотрев интересный и познавательный ролик,
        созданный Телестудией СЮТ:
        <a href="https://www.youtube.com/watch?v=RBC-sXz7pBg" class="text-nowrap">
            https://www.youtube.com/watch?v=RBC-sXz7pBg
        </a>
    </p>

    <section class="mt-5">
        <h2>Как с нами связаться?</h2>

        <div>
            Это можно сделать несколькими путями:

            <ul>
                <li>Телефон: <a href="tel:{{ config('information.ftk.phone') }}">{{ config('information.ftk.phone') }}</a></li>
                <li>Email: <a href="mailto:{{ config('information.ftk.email') }}">{{ config('information.ftk.email') }}</a></li>
                <li>ВКонтакте: <a href="{{ config('information.ftk.vk') }}">{{ config('information.ftk.vk') }}</a></li>
            </ul>

            Или вы можете прийти к нам лично:

            <div class="embed-responsive embed-responsive-16by9 mt-2">
                <iframe
                    class="embed-responsive-item rounded w-100 border"
                    src="{{ config('information.ftk.map_link') }}"
                ></iframe>
            </div>
        </div>
    </section>
@endsection
