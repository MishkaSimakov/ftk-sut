@extends('layouts.page')

@section('content')
    @guest
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Информацию о клубе вы можете посмотреть по адресу <a href="https://ftk-sut.ru/about">ftk-sut.ru/about</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endguest

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
