<div class="card m-3 d-inline-block" style="width: 18rem">
    <div class="card-body">
        <h5 class="card-title">{{ $schedule->title }}</h5>

        <p class="card-text">
            {{ $schedule->date_start->day }} {{ getRussianMonth($schedule->date_start, true) }} {{ $schedule->date_start->format('H:i') }} - {{ $schedule->date_end->format('H:i') }}
        </p>

        @auth
            <a href="#" onclick="event.preventDefault(); addPeople({{ $schedule->id }})" class="btn btn-primary">
                Я пойду <span id="people_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->people_count }}</span>
            </a>
        @endauth
    </div>
</div>
