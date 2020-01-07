<div class="row">
    @foreach($achievements as $achievement)
        <div class="col-md-4 d-flex flex-wrap">
            @component('components.cards.achievement', ['achievement' => $achievement])@endcomponent
        </div>
    @endforeach
</div>
