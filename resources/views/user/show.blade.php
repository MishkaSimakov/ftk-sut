@extends('layouts.page')

@section('content')

<h1 class="text-center m-2">{{ $user->name }}</h1>

@if ($user->student)
    @if (!$achievements->isEmpty())
        @component('components.sections.section', ['header' => 'Достижения'])
            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
        @endcomponent
    @endif
@endif

@if (!$articles->isEmpty())
    @component('components.sections.section', ['header' => 'Статьи'])
        @foreach($articles as $article)
            <h2 class="ml-2"><a href="{{ $article->url }}">{{ \Illuminate\Support\Str::limit($article->title, 45, '...') }}</a></h2>
        @endforeach
    @endcomponent
@endif

@endsection
