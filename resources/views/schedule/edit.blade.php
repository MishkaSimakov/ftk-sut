@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow mt-2">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-primary">Редактировать мероприятие</h4>
                    </div>

                    <div class="card-body">
                        <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('schedule.update', compact('schedule')) }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Название</label>

                                <div class="col-md-6">
                                    <input value="{{ old('title') ?? $schedule->title }}" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subtitle" class="col-md-4 col-form-label text-md-right">Дополнительно</label>

                                <div class="col-md-6">
                                    <input value="{{ old('subtitle') ?? $schedule->subtitle }}" id="subtitle" type="text" class="form-control{{ $errors->has('subtitle') ? ' is-invalid' : '' }}" name="subtitle">

                                    @if ($errors->has('subtitle'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subtitle') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_start" class="col-md-4 col-form-label text-md-right">Дата начала</label>

                                <div class="col-md-6">
                                    <input id="date_start" type="datetime-local" value="{{ old('date_start') ?? $schedule->date_start->format('Y-m-d\TH:i') }}" class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}" name="date_start" min="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

                                    @if ($errors->has('date_start'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_start') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_end" class="col-md-4 col-form-label text-md-right">Дата окончания</label>

                                <div class="col-md-6">
                                    <input id="date_end" type="datetime-local" value="{{ old('date_end') ?? $schedule->date_end->format('Y-m-d\TH:i') }}" class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }}" name="date_end" min="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

                                    @if ($errors->has('date_end'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_end') }}</strong>
                                    </span>
                                    @endif
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
    <script>
        Dropzone.autoDiscover = false;

        var dropzone = new Dropzone('#dropzone', {
            url: "{{ route('api.schedule.upload_image', compact('schedule')) }}",
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

        @foreach($schedule->getMedia() as $media)
            var file = {
                    'name': '{{ $media->file_name }}',
                    'size': '{{ $media->size }}',
                };

            dropzone.emit("addedfile", file);
            dropzone.emit("thumbnail", file, '/image{{ $media->getUrl() }}');
            dropzone.emit("complete", file);
        @endforeach

        dropzone.on('removedfile', function (file) {
            $.ajax({
                url: "{{ route('api.schedule.delete_image', compact('schedule')) }}",
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
