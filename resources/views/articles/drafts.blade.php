@extends('layouts.app')


@section('title', 'Черновики статей')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Черновики статей</h1>

    <div class="mb-5 mt-4">
        @forelse($articles as $article)
            <livewire:articles.article-single :article="$article" :key="$article->id"/>
        @empty
            <div class="my-3 text-center h6 text-info">
                Нет черновиков
            </div>
        @endforelse
    </div>
@endsection
