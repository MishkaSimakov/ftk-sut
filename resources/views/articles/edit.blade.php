@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Статьи')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Редактировать статью</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.update', $article) }}" method="POST">
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
                    <articles-tags-editor
                        tags="{{ $tags->toJson() }}"
                        error="{{ $errors->first('tags') }}"
                        value="{{ old('tags') ?? $article->tags->map(function ($tag) { return ['value' => $tag->name]; })->toJson() }}"
                    ></articles-tags-editor>

                    @error('tags')
                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                </div>

                @admin
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <select id="author"
                                class="custom-select @error('author') is-invalid @enderror" name="author"
                                required autofocus
                        >
                            @foreach($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    @if ((old('author') ?? $article->author_id) === $user->id) selected @endif
                                >
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('author')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endadmin

                <articles-date-editor value_checkbox="{{ old('delayed_publication') ?? $article->is_not_published }}"
                                      value_date="{{ old('date') ?? $article->date }}"></articles-date-editor>

                <div class="d-flex flex-md-row flex-column">
                    <button type="submit" class="btn btn-primary mr-md-3">
                        @admin
                            Опубликовать
                        @else
                            Отправить на проверку
                        @endadmin
                    </button>

                    @can('saveToDrafts', \App\Models\Article::class)
                        <button name="is_draft" value="true" type="submit" class="btn btn-secondary mt-2 mt-md-0">
                            Сохранить в черновики
                        </button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
@endsection
