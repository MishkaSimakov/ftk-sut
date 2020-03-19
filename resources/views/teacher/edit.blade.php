@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow mt-2">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-primary">Редактировать преподавателя</h4>
                    </div>

                    <div class="card-body">
                        <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('admin.teacher.settings', compact('teacher')) }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                                <div class="col-md-6">
                                    <input value="{{ old('last_name') ?? $teacher->last_name }}" id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" required>

                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>

                                <div class="col-md-6">
                                    <input value="{{ old('first_name') ?? $teacher->first_name }}" id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" required>

                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-right">Отчество</label>

                                <div class="col-md-6">
                                    <input value="{{ old('title') ?? $teacher->middle_name }}" id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" name="middle_name" required>

                                    @if ($errors->has('middle_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('middle_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="club_id" class="col-md-4 col-form-label text-md-right">Кружок</label>

                                <div class="col-md-7">
                                    <select class="form-control" id="club_id" name="club_id" required>
                                        @foreach (\App\Club::all() as $club)
                                            <option value="{{ $club->id }}" {{ $teacher->club->id == $club->id ? 'selected' : '' }}>
                                                {{ $club->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="photos" class="col-md-4 col-form-label text-md-right">Фото</label>

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
    <script>
        Dropzone.autoDiscover = false;

        var dropzone = new Dropzone('#dropzone', {
            url: "{{ route('api.teacher.upload_image', compact('teacher')) }}",
            maxFiles: 1,
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

        @if ($teacher->getMedia()->count())
            var file = {
                'name': '{{ $teacher->getMedia()->first()->file_name }}',
                'size': '{{ $teacher->getMedia()->first()->size }}',
            };

            dropzone.emit("addedfile", file);
            dropzone.emit("thumbnail", file, '/image{{ $teacher->getMedia()->first()->getUrl() }}');
            dropzone.emit("complete", file);
        @endif

        dropzone.on('removedfile', function (file) {
            $.ajax({
                url: "{{ route('api.teacher.delete_image', compact('teacher')) }}",
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
