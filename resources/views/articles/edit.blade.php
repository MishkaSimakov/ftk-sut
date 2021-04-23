@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Редактировать статью</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('article.update', $article) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input id="title" type="text"
                           maxlength="75"
                           class="form-control @error('title') is-invalid @enderror" name="title"
                           value="{{ old('title') ?? $article->title }}" required autofocus
                    >

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body">Текст</label>
                    <articles-body-editor error="{{ $errors->first('body') }}"
                                          value="{{ old('body') ?? $article->body }}"></articles-body-editor>

                    @error('body')
                    <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">Теги</label>
                    <articles-tags-editor error="{{ $errors->first('tags') }}"
                                          value="{{ old('tags') ?? $article->tags->map(function ($tag) { return ['value' => $tag->name]; })->toJson() }}"></articles-tags-editor>

                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                </div>

                @if($article->isNotPublished)
                    <articles-date-editor value_checkbox="{{ old('delayed_publication') ?? true }}"
                                          value_date="{{ old('date') ?? $article->date }}"></articles-date-editor>
                @endif
                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
