<div class="row">
    @foreach($teachers as $teacher)
        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
            @component('components.cards.teacher', ['teacher' => $teacher])@endcomponent
        </div>
    @endforeach
</div>
