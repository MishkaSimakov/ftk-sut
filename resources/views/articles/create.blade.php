@extends('layouts.app')


@section('title', 'Новости')

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
                    <articles-body-editor value="{{ old('body') }}"
                                          is-invalid-class="@error('body') is-invalid @enderror"
                    ></articles-body-editor>

                    @error('body')
                    <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">Теги</label>
                    <articles-tags-editor></articles-tags-editor>

                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                </div>

                <articles-date-editor></articles-date-editor>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
