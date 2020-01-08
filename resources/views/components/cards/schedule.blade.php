<div class="schedule card">
    <div class="card-body">
        <h4 class="card-title">{{ $schedule->title }}</h4>

        <p class="card-text">
            <b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}<br>
            <b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}
        </p>
    </div>

    @auth
        @if(now()->lt($schedule->date_start))
            <div class="card-footer">
                <a href="#" onclick='{{ optional(Auth::user())->student ? "event.preventDefault(); addStudent($schedule->id)" : '' }}' class="btn btn-primary">
                    Я пойду <span id="student_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->student_count }}</span>
                </a>
            </div>
        @endif
    @endauth
</div>
