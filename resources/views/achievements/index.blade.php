@include('partials.header')

<h1 class="text-center m-2">Достижения</h1>

<div class="text-center">
  @foreach($achievements as $achievement)
    @component('components.cards.achievement', compact('achievement'))@endcomponent
  @endforeach
</div>

@include('partials.footer')
