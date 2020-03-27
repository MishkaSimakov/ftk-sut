<div>
    <div class="teachers row" id="teachers">
        @foreach($teachers as $teacher)
            @component('components.cards.teacher', ['teacher' => $teacher])@endcomponent
        @endforeach
    </div>
</div>
