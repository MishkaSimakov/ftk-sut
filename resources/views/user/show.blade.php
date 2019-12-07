@include('partials.header')

<h1 class="text-center m-2">{{ $user->name }}</h1>

@if ($achievements->count())
    <div>
        <div class="text-center">
            <h2>Достижения</h2>

            @foreach($achievements as $achievement)
                @component('components.cards.achievement', compact('achievement'))@endcomponent
            @endforeach
        </div>
    </div>
@endif

@include('partials.footer')
