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

        <articles-list show_search="true" url="{{ route('api.articles.get') }}"></articles-list>
    </div>
@endsection

@push('side')
    @component('components.navs.article')@endcomponent
@endpush
