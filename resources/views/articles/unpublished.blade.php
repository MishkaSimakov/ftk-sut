@extends('layouts.app')


@section('title', 'Статьи с отложенной публикацией')

@section('content')
    <h1 class="text-center mb-4">Статьи с отложенной публикацией</h1>

    <div class="mb-5 mt-4">
        @forelse($articles as $article)
           <livewire:articles.article-single :article="$article" :key="$article->id"/>
        @empty
            <p class="text-center h5 text-info">Нет статей с отложенной публикацией.</p>
        @endforelse
    </div>
@endsection
