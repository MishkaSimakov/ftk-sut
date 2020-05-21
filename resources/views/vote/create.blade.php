@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2"></h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mt-2">
                    <div class="card-header">Создать голосование</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('vote.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Название</label>

                                <div class="col-md-6">
                                    <input value="{{ old('title') }}" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Описание</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">
                                        {{ old('description') }}
                                    </textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <add-questions></add-questions>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="multiselect" id="multiselect" {{ old('multiselect') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="multiselect">
                                            Выбор нескольких вариантов
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Создать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
