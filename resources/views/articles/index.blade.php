@extends('layouts.page', ['title' => 'Статьи'])

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1 class="my-2">Статьи</h1>

            @auth
                <span class="h3 my-auto ml-3">
                    <a title="Написать статью" href="{{ route('article.create') }}">
                        <i class="fas fa-pen"></i>
                    </a>
                </span>
            @endauth
        </div>

        <find-articles-form></find-articles-form>

        <div class="row">
            <div class="mt-2 col-lg-8">
                @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
            </div>

            <div id="sidebar" class="col-lg-4 mt-2 d-none d-lg-block">
                <articles-top></articles-top>
                <writers-top></writers-top>
                <comments-top></comments-top>
            </div>
        </div>
    </div>

    <div class="d-flex">
        <div class="mx-auto">
            {{ $articles->appends(['filter' => request()->get('filter'), 'query' => request()->get('query'), 'tag' => request()->get('tag')])->links() }}
        </div>
    </div>
@endsection
