@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Новости')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Создать новость</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('news.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input id="title" type="text"
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
                    <news-body-editor value="{{ old('body') }}"></news-body-editor>

                    @error('body')
                    <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <news-date-editor is-invalid=""></news-date-editor>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
