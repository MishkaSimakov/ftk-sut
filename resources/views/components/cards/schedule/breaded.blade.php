<div class="schedule card shadow">
    <img alt="Изображение мероприятия" class="card-img-top"
         src="{{ $schedule->getMedia()->count() ? $schedule->getMedia()->first()->getUrl() : "https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw_400x400.jpg" }}"
    >

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

                    <a href="{{ route('schedule.edit', compact('schedule')) }}" style="cursor: pointer" class="dropdown-item">
                        Редактировать
                    </a>

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

        @auth
            @if(now()->lt($schedule->date_start))
                <span class="mt-auto {{ $schedule->is_register ? 'schedule__registered' : 'schedule__unregistered' }}" id="register_{{ $schedule->id }}">
                    <a class="text-white btn btn-danger schedule__unregister_link" id="link" onclick="unregister({{ $schedule->id }})">
                        Передумал, не пойду
                    </a>

                    <a class="text-white btn btn-primary schedule__register_link" id="link" onclick="register({{ $schedule->id }})">
                        Пойду
                    </a>
                </span>
            @endif
        @endauth
    </div>
</div>
