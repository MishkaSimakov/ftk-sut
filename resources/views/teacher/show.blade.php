@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $user->teacher->full_name }}</h1>

    <div class="container">
        @if ($user->description)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="font-weight-bold text-primary">О себе</h4>
                </div>

                <div class="card-body">
                    {!! $user->description !!}
                </div>
            </div>
        @endif

        @if (!$user->articles->isEmpty())
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="font-weight-bold text-primary">Статьи</h4>
                </div>

                <div class="card-body">
                    @foreach($user->articles->where('is_published', true) as $article)
                        <h5><a href="{{ $article->url }}">{{ $article->title }}</a></h5>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
