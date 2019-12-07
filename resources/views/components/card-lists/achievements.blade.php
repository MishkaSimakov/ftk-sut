<div class="row">
    @foreach($achievements as $achievement)
        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
            @component('components.cards.achievement', ['achievement' => $achievement])@endcomponent
        </div>
    @endforeach
</div>
