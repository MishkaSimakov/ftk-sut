@extends('layouts.page')

@section('content')

<h1 class="text-center m-2">Достижения</h1>

<div class="container">
{{--    TODO: сделать красиво тут --}}
    @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
</div>

@endsection
