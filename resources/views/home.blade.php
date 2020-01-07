@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Домик</h1>

    @if ($achievements)
        @component('components.sections.section', ['header' => 'Достижения'])
            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
        @endcomponent
    @endif
@endsection
