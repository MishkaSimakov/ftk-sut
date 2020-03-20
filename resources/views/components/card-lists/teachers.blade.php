<div>
    <div class="teachers row" id="teachers">
        @foreach($teachers as $teacher)
            @component('components.cards.teacher', ['teacher' => $teacher])@endcomponent
        @endforeach
    </div>

    <button id="teachersToggle">
        <span class="none-toggled--teachers">Показать всех</span>
        <span class="toggled--teachers">Скрыть</span>
    </button>
</div>
