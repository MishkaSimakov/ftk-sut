@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Требуют проверки</h1>

    <div class="mb-5 mt-4">
        @foreach($articles as $article)
           <articles-article :article="{{ $article->toJson() }}"></articles-article>
        @endforeach
    </div>
@endsection
