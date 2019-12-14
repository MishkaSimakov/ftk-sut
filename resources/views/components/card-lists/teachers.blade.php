<div class="row">
    @foreach($teachers as $teacher)
        <div class="col-md-4">
            @component('components.cards.teacher', ['teacher' => $teacher])@endcomponent
        </div>
    @endforeach
</div>

