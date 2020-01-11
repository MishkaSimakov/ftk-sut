<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
{{--            TODO: сделать высоту по размеру div --}}
            <img class="card-img img-fluid" style="object-fit: cover;" src="/image/{{ $schedule->getMedia()->first()->getUrl() }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{ $schedule->title }}</h5>
                <p class="card-text"><b>Начало:</b> {{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>
                <p class="card-text"><b>Конец:</b> {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }}</p>

                @auth
                    @if(now()->lt($schedule->date_start) && Auth::user()->student)
                        <div class="">
                            <a href="#" onclick='{{ optional(Auth::user())->student ? "event.preventDefault(); addStudent($schedule->id)" : '' }}' class="btn btn-primary">
                                Я пойду <span id="student_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->student_count }}</span>
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
