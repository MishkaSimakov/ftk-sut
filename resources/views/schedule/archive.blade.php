@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Архив мероприятий</h1>

    <div class="container">
        @component('components.card-lists.schedules', ['schedules' => $schedules, 'archived' => true])@endcomponent
    </div>
@endsection
