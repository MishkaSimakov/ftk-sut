@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $user->teacher->full_name }}</h1>

    <div class="container">
        <div class="alert alert-info alert-dismissible fade show" role="contentinfo">
            Пока что здесь ничего нет, но очень скоро что-то будет!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold text-primary">Статьи</h4>
            </div>

            <div class="card-body">
                @if (!$user->articles->isEmpty())
                    @foreach($user->articles->where('is_published', true) as $article)
                        <h5><a href="{{ $article->url }}">{{ $article->title }}</a></h5>
                    @endforeach
                @else
                    <row>
                        <strong>Похоже у вас нет статей! Напишите первую прямо сейчас:</strong>

                        <a class="text-white ml-3 btn btn-info" href="{{ route('article.create') }}"><i class="fas fa-plus mr-1"></i>Написать статью</a>
                    </row>
                @endif
            </div>
        </div>
    </div>
@endsection