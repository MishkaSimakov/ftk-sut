<div class="mb-2 card shadow w-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 p-0">
                <img data-lity src="{{ $schedule->imageUrl }}" class="h-100 w-100 card-img" style="cursor: pointer; object-fit: cover">
            </div>
            <div class="d-flex flex-column col-md-9 py-2 px-3">
                <div class="card-title">
                    @admin
                        <div class="dropdown no-gutters float-right mr-1">
                            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a href="{{ route('schedule.edit', compact('schedule')) }}" style="cursor: pointer" class="dropdown-item">
                                    Редактировать
                                </a>

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

                    <h5 class="font-weight-bold text-primary">
                        {{ $schedule->title }}
                    </h5>
                </div>

                <h6 class="card-subtitle mb-2 text-muted">{{ $schedule->subtitle }}</h6>
                <p class="card-text"><b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
                <p class="card-text mb-2"><b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>

                @can('sign', $schedule)
                    <sign-button
                        url="{{ route('schedule.sign', compact('schedule')) }}"
                        data="{{ $schedule->load('users')->toJson() }}"
                        class="mt-auto"
                    ></sign-button>
                @endcan
            </div>
        </div>
    </div>
</div>
