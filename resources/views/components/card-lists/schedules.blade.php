@foreach($schedules as $schedule)
    @component('components.cards.schedule', ['schedule' => $schedule])@endcomponent
@endforeach
