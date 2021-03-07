@extends('layouts.app')


@section('title', 'Новости')

@section('content')
    <h1 class="text-center">Новая новость</h1>

    <div class="card">
        <div class="card-body">
            <form>
                 <div class="form-group">
                     <label for="title">Заголовок</label>
                     <input id="title" type="text"
                            class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title') ?? $news->title }}" required autofocus
                     >

                     @error('title')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="body">Заголовок</label>
                     <news-editor value="{{ old('body') ?? $news->body }}"
                            is-invalid-class="@error('body') is-invalid @enderror"
                     ></news-editor>

                     @error('body')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="date">Дата публикации</label>
                     <input id="date" type="date"
                            class="form-control @error('date') is-invalid @enderror" name="date"
                            value="{{ old('date') ?? $news->date->isoFormat('YYYY-MM-DD') }}" required autofocus
                     >

                     @error('date')
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
