@extends('layouts.page')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow mt-2">
                <div class="card-header">
                    <h4 class="font-weight-bold text-primary">Статья</h4>
                </div>

                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('article.update', compact('article')) }}">
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Название статьи</label>

                            <div class="col-md-7">
                                <input max="100" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') ?? $article->title }}" required>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editor" class="col-md-4 col-form-label text-md-right">Статья</label>

                            <div class="col-md-7 mb-5">
                                <input type="hidden" name="body" id="body">

                                <div id="editor">
                                    {!! old('body') ?? $article->body !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photos" class="col-md-4 col-form-label text-md-right">Фотографии</label>

                            <div class="col-md-7">
                                <div class="dropzone" id="dropzone"></div>
                            </div>
                        </div>

                        @admin
                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label text-md-right">Автор</label>

                                <div class="col-md-7">
                                    <input list="users" id="user" type="text" class="form-control" name="author" value="{{ optional($article->user)->name ?? Auth::user()->name }}">
                                </div>

                                <datalist id="users">
                                    @foreach($names as $name)
                                        <option>{{ $name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        @endadmin

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
    <script>
        $(document).ready(function () {
            var quill = new Quill('#editor', {
                theme: 'snow',
            });

            $('#form').submit(function () {
                $('#body').val($('.ql-editor').html())
            });
        });



        {{--  dropzone  --}}
        Dropzone.autoDiscover = false;

        var article_dropzone = new Dropzone('#dropzone', {
            url: "{{ route('api.article.upload_image', compact('article')) }}",
            maxFiles: 15,
            acceptedFiles: 'image/*',

            addRemoveLinks: true,

            //translations
            dictFileTooBig: "Файл слишком большой!",
            dictInvalidFileType: "Данный тип файла не поддерживается!",
            dictDefaultMessage: "<p>Перенесите фалйы сюда или нажмите, чтобы выбрать из папки</p>",
            dictCancelUpload: "отменить загрузку",
            dictRemoveFile: 'удалить файл',
            dictCancelUploadConfirmation: 'Отменить загрузку?'
        });

        @foreach($article->getMedia() as $media)
            var file = {
                'name': '{{ $media->file_name }}',
                'size': '{{ $media->size }}',
            };

            article_dropzone.emit("addedfile", file);
            article_dropzone.emit("thumbnail", file, '{{ $media->getUrl() }}');
            article_dropzone.emit("complete", file);
        @endforeach

        article_dropzone.on('removedfile', function (file) {
            $.ajax({
                url: "{{ route('api.article.delete_image', compact('article')) }}",
                method: "POST",
                dataType: 'json',
                data: {
                    name: file.name,
                },
                success: function (data) {
                    console.log(data)
                }
            });
        })
    </script>
@endpush
