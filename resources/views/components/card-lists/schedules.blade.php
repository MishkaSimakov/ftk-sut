<div class="row">
    @foreach($schedules as $schedule)
        <div class="col-md-4 d-flex flex-wrap">
            @if($archived)
                @component('components.cards.schedule.archived', ['schedule' => $schedule])@endcomponent
            @else
                @component('components.cards.schedule.breaded', ['schedule' => $schedule])@endcomponent
            @endif
        </div>
    @endforeach
</div>
