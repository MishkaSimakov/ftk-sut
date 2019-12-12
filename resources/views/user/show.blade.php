@extends('layouts.page')

@section('content')

<h1 class="text-center m-2">{{ $user->name }}</h1>

@if ($achievements->count())
    @component('components.sections.teachers', ['header' => 'Достижения'])
        @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
    @endcomponent
@endif

@endsection
