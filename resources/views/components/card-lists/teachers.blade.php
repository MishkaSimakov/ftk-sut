@foreach($teachers as $teacher)
    @component('components.cards.teacher', ['teacher' => $teacher])@endcomponent
@endforeach
