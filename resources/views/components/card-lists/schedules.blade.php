<div class="row">
    @foreach($schedules as $schedule)
        <div class="col-md-4 d-flex flex-wrap">
            @component('components.cards.schedule', ['schedule' => $schedule])@endcomponent
        </div>
    @endforeach
</div>
