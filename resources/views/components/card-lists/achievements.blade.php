<div class="row">
    @foreach($achievements as $achievement)
        <div class="col-lg-4 col-md-6 d-flex flex-wrap">
            @component('components.cards.achievement', ['achievement' => $achievement])@endcomponent
        </div>
    @endforeach
</div>
