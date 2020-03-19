<div class="schedule card shadow schedule__archived" data-toggle="modal" data-target="#photos_schedule_{{ $schedule->id }}">
    <img alt="Изображение мероприятия" class="card-img-top"
         src="/image/{{ $schedule->getMedia() ? $schedule->getMedia()->first()->getUrl() : "https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw_400x400.jpg" }}"
    >

    <div class="schedule__gallery"><i style="color: black;" class="fa-7x fas fa-images"></i></div>

    <div class="card-body d-flex flex-column">
        <div class="card-title d-flex flex-row align-items-center justify-content-between">
            <h5 class="d-block font-weight-bold text-primary">
                {{ $schedule->title }}
            </h5>

            @admin
                <div class="schedule__image_dropdown dropdown no-gutters">
                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header font-weight-bold">Дополнительно:</div>

                        <div class="dropdown-divider"></div>

                        <a style="cursor: pointer" class="text-danger dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $schedule->id }}').submit();">
                            Удалить
                        </a>

                        <form method="POST" action="{{ route('schedule.destroy', compact('schedule')) }}" id="delete-form-{{ $schedule->id }}">
                            @csrf
                            @method("DELETE")
                        </form>
                    </div>
                </div>
            @endadmin
        </div>

        <h6 class="card-subtitle mb-2 text-muted">{{ $schedule->subtitle }}</h6>
        <p class="card-text"><b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
        <p class="card-text mb-2"><b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
    </div>
</div>

<div class="modal fade" id="photos_schedule_{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="SchedulePhotos" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ $schedule->title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @foreach($schedule->getMedia() as $media)
                    <div class="col-md-2 m-2 p-0 d-inline-block">
                        <img alt="Фотография с мероприятия" class="mw-100 mh-100 rounded" src="/image/{{ $media->getUrl() }}" style="cursor: pointer" data-lity data-lity-target="/image/{{ $media->getUrl() }}">
                    </div>
                @endforeach
            </div>

            @admin
                <div class="m-3">
                    <div class="dropzone" id="dropzone_{{ $schedule->id }}"></div>
                </div>
            @endadmin
        </div>
    </div>
</div>

@push('script')
    <script>
        {{--  dropzone  --}}
        Dropzone.autoDiscover = false;

        var schedule_dz = new Dropzone('#dropzone_{{ $schedule->id }}', {
            url: "{{ route('api.schedule.upload_image', compact('schedule')) }}",
            maxFiles: 25,
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

        schedule_dz.on('removedfile', function (file) {
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
        });
    </script>
@endpush
