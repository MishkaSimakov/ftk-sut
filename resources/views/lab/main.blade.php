@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <a class="m-1 h4" href="{{ route('main') }}">
        <i class="fas fa-arrow-left mr-1"></i>
        Обратно на сайт
    </a>

    <div class="my-5 ml-5">
        <h1 class="display-1 font-weight-bold">
            <span class="d-none d-md-inline">Laboratory</span><span class="d-inline d-md-none">Lab</span> 🧪
        </h1>
        <small class="h4 text-muted">Рубрика ээээксперименты!</small>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="font-weight-bold">Эксперименты</h2>

                <ul class="list-unstyled">
                    <li class="h3 font-weight-light"><a href="{{ route('lab.live') }}">Клеточные автоматы</a></li>
                    <li class="h3 font-weight-light"><a href="{{ route('lab.mandelbrot') }}">Крутой фрактал</a></li>
{{--                    <li class="h3 font-weight-light"><a href="{{ route('lab.place') }}">Немного рисунков</a></li>--}}
{{--                    <li class="h3 font-weight-light"><a href="{{ route('lab.shadow') }}">Тени</a></li>--}}
                    <li class="h3 font-weight-light"><a href="{{ route('lab.primes') }}">Простые числа</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-bold text-muted">Скоро</h2>
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-bold text-muted">Скоро</h2>
            </div>
        </div>
    </div>

    <p class="text-muted fixed-bottom ml-2"><a href="https://sunandstuff.com/">Sunandstuff</a> на минималках</p>
    <p class="text-muted fixed-bottom mr-2"><a class="position-absolute" style="right: 0; bottom: 0;" href="https://vk.com/simakovkin">@simakovkin</a></p>
@endsection
