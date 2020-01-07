@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Настроить аккаунт</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Адрес электронной почты</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" autofocus>
                                </div>
                            </div>

                            @if (Auth::user()->student)
                                <div class="form-group row">
                                    <label for="birthday" class="col-sm-4 col-form-label text-md-right">Дата рождения</label>

                                    <div class="col-md-6">
                                        <input id="birthday" type="date" class="form-control" name="birthday" value="{{ optional(Auth::user()->student->birthday)->isoFormat('Y-MM-DD') }}" autofocus>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">Изменить пароль</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.changePassword') }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label text-md-right">Пароль</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-sm-4 col-form-label text-md-right">Повторите пароль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    TODO: сделать настройку аккаунта: пароль, email, дата рождения и поступления в клуб --}}

@endsection
