@extends('layouts.app')


@section('title', 'Расписание')
@section('description', 'Прошедшие мероприятия ФТК со списком участников и подробной информацией.')
@section('robots', 'index, follow, noarchive')

@section('content')
    <h1 class="text-center mb-4">Прошедшие мероприятия</h1>

    @forelse($events as $event)
        @include('events.event-card', $event)
    @empty
        <div class="my-3 text-center h6 text-info">
            Нет мероприятий
        </div>
    @endforelse

        <div class="row no-gutters">
            <div class="mx-auto">
                {{ $events->links() }}
            </div>
        </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
