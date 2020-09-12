@extends('layouts.page')

@section('content')

    <div class="card shadow mt-2">
        <div class="card-header">Создать пользователя</div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="surname" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                    <div class="col-md-6">
                        <input value="{{ old('surname') }}" id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" required>

                        @if ($errors->has('surname'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('surname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                    <div class="col-md-6">
                        <input value="{{ old('name') }}" id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">

                            <label class="form-check-label" for="is_admin">
                                Администратор
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

@endsection
