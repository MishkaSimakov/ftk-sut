@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ Auth::user()->name }}</h1>

    @if ($user->description)
        @component('components.sections.section', ['header' => 'О себе'])
            {!! $user->description !!}
        @endcomponent
    @endif

    @if ($achievements)
        @component('components.sections.section', ['header' => 'Достижения'])
            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
        @endcomponent
    @endif

    @if (!$user->articles->isEmpty())
        @component('components.sections.section', ['header' => 'Статьи'])
            @foreach($user->articles as $article)
                <h2 class="ml-2"><a href="{{ $article->url }}">{{ \Illuminate\Support\Str::limit($article->title, 45, '...') }}</a></h2>
            @endforeach
        @endcomponent
    @endif
@endsection
