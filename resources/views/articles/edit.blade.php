@extends('layouts.page')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card mt-2">
                <div class="card-header">Редактирование статьи</div>

                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('article.update', compact('article')) }}">
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Название статьи</label>

                            <div class="col-md-7">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $article->title }}" required>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="editor" class="col-md-4 col-form-label text-md-right">Статья</label>

                            <div class="col-md-7 mb-5">
                                <input type="hidden" name="body" id="body">

                                <div id="editor" class="form-control">
                                    {!! $article->body !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photos" class="col-md-4 col-form-label text-md-right">Фотографии</label>

                            <div class="col-md-7">
                                <div class="dropzone" id="dropzone"></div>
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
            $('#body').val($('.ql-editor').html())
        })

        $('#dropzone').dropzone({
            url: "{{ route('api.image.upload', compact('article')) }}",
            maxFiles: 15,
            acceptedFiles: 'image/*',

            //translations
            dictFileTooBig: "Файл слишком большой!",
            dictInvalidFileType: "Данный тип файла не поддерживается!",
            dictDefaultMessage: "<p>Перенесите фалйы сюда или нажмите, чтобы выбрать из папки</p>"
        });
    </script>
@endpush
