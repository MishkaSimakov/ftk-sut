@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow mt-2">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-primary">Новость</h4>
                    </div>

                    <div class="card-body">
                        <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('news.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Название новости</label>

                                <div class="col-md-7">
                                    <input max="100" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="editor" class="col-md-4 col-form-label text-md-right">Текст</label>

                                <div class="col-md-7 mb-5">
                                    <input type="hidden" name="body" id="body">

                                    <div id="editor">
                                        {!! old('body') !!}
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
            </div>
        </div>
    </div>

@endsection

@push('script')
    {{--  text editor  --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        $(document).ready(function () {
            var quill = new Quill('#editor', {
                theme: 'snow',
            });

            $('#form').submit(function () {
                $('#body').val($('.ql-editor').html())
            });
        });
    </script>
@endpush
