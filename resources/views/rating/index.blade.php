@include('partials.header')

<h1 class="text-center m-2">Рейтинг</h1>

@admin
    <h2 class="ml-2"><a href="{{ route('rating.create') }}"><i class="fas fa-plus mr-1"></i>Добавить рейтинг</a></h2>
@endadmin

@foreach($ratings as $rating)
    <h2 class="ml-2"><a href="{{ $rating->url }}">{{ $rating->name }}</a></h2>
@endforeach

@include('partials.footer')
