@extends('layouts.app')


@section('title', 'Расписание')
@section('description', 'Ближайшие мероприятия ФТК со списком участников и подробной информацией.')
@section('robots', 'index, follow, noarchive')

@section('content')
    <h1 class="text-center mb-4">Расписание</h1>

    @forelse($events as $event)
        @include('events.event-card', $event)
    @empty
        <div class="my-3 text-center h6 text-info">
            Нет мероприятий
        </div>
    @endforelse
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
