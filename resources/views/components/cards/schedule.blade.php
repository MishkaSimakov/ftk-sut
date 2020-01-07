<div class="schedule card">
    <div class="card-body">
        <h4 class="card-title">{{ $schedule->title }}</h4>

{{--        TODO: сделать названия месяцев на русском языке --}}
        <p class="card-text">
            <b>Начало:</b> {{ \Carbon\Carbon::parse('2018-03-16 15:45')->locale('uk')->translatedFormat('g:i a l jS F Y') }}<br>
            <b>Конец:</b> {{ $schedule->date_end->day }} {{ getRussianMonth($schedule->date_end, true) }} {{ $schedule->date_end->format('H:i') }}
        </p>

        @auth
            @if(now() < $schedule->date_start)
                <a href="#" onclick='{{ optional(Auth::user())->student ? "event.preventDefault(); addStudent($schedule->id)" : '' }}' class="d-flex btn btn-primary">
                    Я пойду <span id="student_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->student_count }}</span>
                </a>
            @endif
        @endauth
    </div>
</div>
