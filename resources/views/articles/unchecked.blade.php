@extends('layouts.app')

@section('title', 'Непроверенные статьи')

@section('content')
    <h1 class="text-center mb-4">Требуют проверки</h1>

    <div class="mb-5 mt-4">
        @forelse($articles as $article)
           <livewire:articles.article-single :article="$article" :key="$article->id"/>
        @empty
            <p class="text-center h5 text-info">Нет статей для проверки.</p>
        @endforelse
    </div>
@endsection
