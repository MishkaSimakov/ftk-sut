@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center">Статьи</h1>

    <input class="form-control mb-5" placeholder="Поиск статей">

    {{-- Best articles --}}
    <section class="mb-5">
        <h3 class="text-left font-weight-bold">Лучшее на ftk-sut.ru</h3>
{{--                <articles-article class="mt-3" :article="{{ $articles->get(1)->toJson() }}"></articles-article>--}}

{{--                <div class="row">--}}
{{--                    <div class="col-md-6 mt-3">--}}
{{--                        <articles-article class="mt-3" :article="{{ $articles->get(2)->toJson() }}"></articles-article>--}}
{{--                    </div>--}}

{{--                    <div class="col-md-6 mt-3">--}}
{{--                        <articles-article class="mt-3" :article="{{ $articles->get(3)->toJson() }}"></articles-article>--}}
{{--                    </div>--}}
{{--                </div>--}}
        {{--        TODO: заменить это всё на articles-top-list --}}
{{--        <p class="text-center text-muted my-5">Временно не работает...</p>--}}
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
                        Рукоделие
                    </a>
                    <a href="#" class="col-md-3 text-center border-right py-2">
                        Котики
                    </a>
                    <a href="#" class="col-md-3 text-center py-2">
                        Что-то ещё
                    </a>
                </div>
            </div>
            {{--            TODO: заменить это всё на popular-article-tags-list --}}
        </div>
    </section>

    <section>
        <h3 class="text-left font-weight-bold">Все статьи</h3>

        <articles-list></articles-list>
    </section>
@endsection
