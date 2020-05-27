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

        <div class="mt-2">
            @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
        </div>
    </div>

    <div class="d-flex">
        <div class="mx-auto">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>
@endsection

@push('side')
    <articles-top></articles-top>
    <writers-top></writers-top>
    <comments-top></comments-top>
@endpush
