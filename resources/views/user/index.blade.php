@include('partials.header')

<h1 class="text-center m-2">Обучающиеся ФТК-СЮТ</h1>

@foreach($users as $user)
	<h2 class="ml-2"><a href="{{ $user->url }}">{{ $user->name }}</a></h2>
@endforeach

@include('partials.footer')