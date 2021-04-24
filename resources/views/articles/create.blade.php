@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Написать статью</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('article.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input id="title" type="text"
                           maxlength="75"
                           class="form-control @error('title') is-invalid @enderror" name="title"
                           value="{{ old('title') }}" required autofocus
                    >

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body">Текст</label>
                    <articles-body-editor error="{{ $errors->first('body') }}" value="{{ old('body') }}"></articles-body-editor>

                    @error('body')
                    <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">Теги</label>
                    <articles-tags-editor error="{{ $errors->first('tags') }}" value="{{ old('tags') }}"></articles-tags-editor>

                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                </div>

                <articles-date-editor value_checkbox="{{ old('delayed_publication') }}" value_date="{{ old('date') }}"></articles-date-editor>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
