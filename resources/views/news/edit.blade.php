@extends('layouts.app')


@section('title', 'Новости')

@section('content')
    <h1 class="text-center">Новая новость</h1>

    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок новости">
                </div>
                <div class="form-group">
                    <label for="body">Текст</label>
                    <news-editor></news-editor>
                </div>

                <div class="form-group">
                    <label for="date">Дата публикации</label>
                    <input type="datetime-local" class="form-control" id="date" name="date">
                </div>

{{--                <div class="alert alert-info" role="alert">--}}
{{--                    Новость будет опубликована 19 января 2020г. в 20:00--}}
{{--                </div>--}}

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
