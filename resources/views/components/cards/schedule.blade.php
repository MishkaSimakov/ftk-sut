<div class="schedule card">
    <img class="card-img-top" src="/image/{{ $schedule->getMedia()->first()->getUrl() }}">

    <div class="card-body">
        <h5 class="card-title">{{ $schedule->title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $schedule->subtitle }}</h6>
        <p class="card-text"><b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
        <p class="card-text"><b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>

        @auth
            @if(now()->lt($schedule->date_start) && Auth::user()->student)
                <div>
                    <a href="#" onclick='event.preventDefault(); addStudent({{ $schedule->id }})' class="btn btn-primary">
                        Я пойду <span id="student_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->student_count }}</span>
                    </a>

                    <a href="#" onclick='event.preventDefault(); removeStudent({{ $schedule->id }})' class="btn btn-danger">
                        Передумал, не пойду <span id="student_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->student_count }}</span>
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>
