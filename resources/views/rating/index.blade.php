@include('partials.header')

<div class="nav-scroller bg-white shadow-sm">
  <nav class="nav nav-underline">
    <a class="nav-link" href="{{ route('rating.index') }}">Ученики</a>
    <a class="nav-link" href="{{ route('rating.index') }}?type=teachers">
    	Преподователи
    	<span class="badge badge-pill bg-dark align-text-bottom">beta</span>
    </a>
  </nav>
</div>

<h1 class="text-center m-2">Рейтинг</h1>

@auth
  @if (Auth::user()->isAdmin)
    <h2 class="ml-2"><a href="{{ route('rating.create') }}"><i class="fas fa-plus mr-1"></i>Добавить рейтинг</a></h2>
  @endif
@endauth

@foreach($ratings as $rating)
    <h2 class="ml-2"><a href="{{ $rating->url }}">{{ $rating->name }}</a></h2>
@endforeach

@include('partials.footer')
