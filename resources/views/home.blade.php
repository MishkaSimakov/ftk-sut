@include('partials.header')

<h1 class="text-center m-2">Домик</h1>

@if ($achievements->count())
    <div>
        <div class="text-center">
            <h2>Достижения</h2>

            @foreach($achievements as $achievement)
                @component('components.cards.teacher', compact('teacher'))@endcomponent
            @endforeach
        </div>
    </div>
@endif

@include('partials.footer')
