@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Требуют проверки</h1>

    <div class="mb-5 mt-4">
        @forelse($articles as $article)
           <articles-article :article="{{ $article->toJson() }}"></articles-article>
        @empty
            <p class="text-center h5 text-info">Нет статей для проверки.</p>
        @endforelse
    </div>
@endsection
