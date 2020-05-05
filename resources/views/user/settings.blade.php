@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-2">
                    <div class="card-header">Настроить аккаунт</div>

                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ?? Auth::user()->email }}" autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if (Auth::user()->student)
                                <div class="form-group row">
                                    <label for="birthday" class="col-sm-4 col-form-label text-md-right">Дата рождения</label>

                                    <div class="col-md-6">
                                        <input id="birthday" type="date" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" value="{{ old('birthday') ?? optional(Auth::user()->student->birthday)->isoFormat('Y-MM-DD') }}" min="2000-01-01" autofocus>

                                        @if ($errors->has('birthday'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('birthday') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="editor" class="col-md-4 col-form-label text-md-right">О себе</label>

                                <div class="col-md-7 mb-5">
                                    <input type="hidden" name="description" id="description">

                                    <div id="editor">
                                        {!! old('description') ?? Auth::user()->description !!}
                                    </div>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-4 col-form-label text-md-right">Телефон</label>

                                <div class="col-md-6">
                                    <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?? Auth::user()->phone }}" autofocus>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vk_link" class="col-sm-4 col-form-label text-md-right">Профиль ВК</label>

                                <div class="col-md-6">
                                    <input placeholder="https://vk.com/... " id="vk_link" type="text" class="form-control{{ $errors->has('vk_link') ? ' is-invalid' : '' }}" name="vk_link" value="{{ old('vk_link') ?? Auth::user()->vk_link }}" autofocus>

                                    @if ($errors->has('vk_link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('vk_link') }}</strong>
                                        </span>
                                    @endif
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

{{--                <div class="card mt-2">--}}
{{--                    <div class="card-header">Изменить пароль</div>--}}

{{--                    <div class="card-body">--}}
{{--                        <form method="POST" action="{{ route('settings.update') }}">--}}
{{--                            @csrf--}}
{{--                            @method("PUT")--}}

{{--                            <div class="form-group row">--}}
{{--                                <label for="password" class="col-sm-4 col-form-label text-md-right">Пароль</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input type="password" id="password" class="form-control" name="password" autofocus>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row">--}}
{{--                                <label for="password-confirm" class="col-sm-4 col-form-label text-md-right">Повторите пароль</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autofocus>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row mb-0">--}}
{{--                                <div class="col-md-8 offset-md-4">--}}
{{--                                    <button type="submit" class="btn btn-primary">--}}
{{--                                        Сохранить--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        let quill = new Quill('#editor', {
            theme: 'snow',
        });

        $('#form').submit(function () {
            $('#description').val($('.ql-editor').html())
        })
    </script>
@endpush
