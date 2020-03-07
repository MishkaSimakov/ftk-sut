<div class="schedule card">
    <img alt="Изображение мероприятия" class="card-img-top" src="/image/{{ $schedule->getMedia()->first()->getUrl() }}">

    <div class="card-body d-flex flex-column">
        <h5 class="card-title row">
            {{ $schedule->title }}
            <div class="ml-3 schedule__image_dropdown dropdown no-gutters">
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header font-weight-bold">Дополнительно:</div>

                    @admin
                        <div class="dropdown-divider"></div>

                        <a style="cursor: pointer" class="text-danger dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $schedule->id }}').submit();">
                            Удалить
                        </a>

                        <form method="POST" action="{{ route('schedule.destroy', compact('schedule')) }}" id="delete-form-{{ $schedule->id }}">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endadmin
                </div>
            </div>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $schedule->subtitle }}</h6>
        <p class="card-text"><b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
        <p class="card-text mb-2"><b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>

        @auth
            @if(now()->lt($schedule->date_start) && Auth::user()->student)
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
