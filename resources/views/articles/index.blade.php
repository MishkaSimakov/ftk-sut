@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center">Статьи</h1>

    <articles-search></articles-search>

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

        <articles-top-tags-list></articles-top-tags-list>
    </section>

    <section>
        <h3 class="text-left font-weight-bold">Все статьи</h3>

        <articles-list></articles-list>
    </section>
@endsection
