@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Auth::user()->student)
                    <div class="card mt-2">
                        <div class="card-header">Настроить аккаунт</div>

                        <div class="card-body">
                            <form id="form" method="POST" action="{{ route('settings.update') }}">
                                @csrf
                                @method("PUT")

                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

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

                                <div class="form-group row">
                                    <label for="editor" class="col-md-4 col-form-label text-md-right">О себе</label>

                                    <div class="col-md-7 mb-5">
                                        <input type="hidden" name="description" id="description">

                                        <div id="editor">
                                            {!! Auth::user()->description !!}
                                        </div>
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
                @endif

                <div class="card mt-2">
                    <div class="card-header">Изменить пароль</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label text-md-right">Пароль</label>

                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" autofocus>
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

@endsection

@push('script')
    {{--  text editor  --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
        });

        $('#form').submit(function () {
            $('#description').val($('.ql-editor').html())
        })
    </script>
@endpush
