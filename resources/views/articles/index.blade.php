@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center">Статьи</h1>

    <input class="form-control mb-5" placeholder="Поиск статей">

    {{-- Best articles --}}
    <section class="mb-5">
        <h3 class="text-left font-weight-bold">Лучшее на ftk-sut.ru</h3>


        <articles-article class="mt-3" :article="{{ $articles->get(1)->toJson() }}"></articles-article>

        <div class="row">
            <div class="col-md-6 mt-3">
                <articles-article class="mt-3" :article="{{ $articles->get(2)->toJson() }}"></articles-article>
            </div>

            <div class="col-md-6 mt-3">
                <articles-article class="mt-3" :article="{{ $articles->get(3)->toJson() }}"></articles-article>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <h3 class="text-left font-weight-bold">Популярные категории</h3>

        <div class="card mt-3">
            <div class="card-body py-2">
                <div class="row">
                    <a href="#" class="col-md-3 text-center border-right py-2">
                        Робототехника
                    </a>
                    <a href="#" class="col-md-3 text-center border-right py-2">
                        Не робототехника
                    </a>
                    <a href="#" class="col-md-3 text-center border-right py-2">
                        Котики
                    </a>
                    <a href="#" class="col-md-3 text-center py-2">
                        Что-то ещё
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h3 class="text-left font-weight-bold">Все статьи</h3>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Привет мир!</h5>
                <div class="card-text">Lorem Ipsum или как там начинается... Всем привет, в этой статье, которую вы,
                    скорее
                    всего, читаете на сайте ftk-sut.ru прямо сейчас на планете Земля, я, со всей присущей мне
                    честностью,
                    расскажу подробно и без лишних деталей: как профессионально лить воду...
                </div>

                <div class="text-muted mt-3">
                    Симаков Михаил • 29 июня 2021
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Привет мир!</h5>
                <div class="card-text">Lorem Ipsum или как там начинается... Всем привет, в этой статье, которую вы,
                    скорее
                    всего, читаете на сайте ftk-sut.ru прямо сейчас на планете Земля, я, со всей присущей мне
                    честностью,
                    расскажу подробно и без лишних деталей: как профессионально лить воду...
                </div>

                <div class="text-muted mt-3">
                    Симаков Михаил • 29 июня 2021
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Привет мир!</h5>
                <div class="card-text">Lorem Ipsum или как там начинается... Всем привет, в этой статье, которую вы,
                    скорее
                    всего, читаете на сайте ftk-sut.ru прямо сейчас на планете Земля, я, со всей присущей мне
                    честностью,
                    расскажу подробно и без лишних деталей: как профессионально лить воду...
                </div>

                <div class="text-muted mt-3">
                    Симаков Михаил • 29 июня 2021
                </div>
            </div>
        </div>
    </section>
@endsection
