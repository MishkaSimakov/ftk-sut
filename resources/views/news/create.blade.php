@extends('layouts.app')


@section('title', 'Новости')

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
                    <news-body-editor value="{{ old('body') }}"
                                 isInvalidClass="@error('body') is-invalid @enderror"
                    ></news-body-editor>

                    @error('body')
                    <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date">Дата публикации</label>
                    <input id="date" type="date"
                           class="form-control @error('date') is-invalid @enderror" name="date"
                           value="{{ old('date') }}" required autofocus
                    >

                    @error('date')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>

                 <div class="form-check">
                     <input id="notify_users" type="checkbox"
                            class="form-check-input @error('notify_users') is-invalid @enderror" name="notify_users"
                            {{ old('notify_users') == 'on' ? 'checked' : '' }} autofocus
                     >
                     <label for="notify_users" class="form-check-label">Оповестить пользователей</label>

                     @error('notify_users')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                {{--                <div class="alert alert-info" role="alert">--}}
                {{--                    Новость будет опубликована 19 января 2020г. в 20:00--}}
                {{--                </div>--}}

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
