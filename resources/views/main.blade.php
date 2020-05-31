@extends('layouts.page')

@section('content')
    @if($news->count())
        <h2 class="text-center my-2">Последние новости</h2>
        @component('components.card-lists.news', ['news' => $news])@endcomponent

        <div class="text-center h5 mt-1 mb-4">
            <a href="{{ route('news.index') }}">
                Смотреть все
            </a>
        </div>
    @endif

    @if($articles->count())
        <hr>

        <h2 class="text-center my-2">Последние статьи</h2>
        @component('components.card-lists.articles', ['articles' => $articles])@endcomponent

        <div class="text-center h5 mt-1 mb-4">
            <a href="{{ route('article.index') }}">
                Смотреть все
            </a>
        </div>
    @endif
@endsection
