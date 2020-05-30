@foreach($achievements as $achievement)
        @component('components.cards.achievement', ['achievement' => $achievement])@endcomponent
@endforeach
