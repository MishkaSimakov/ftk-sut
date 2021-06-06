@extends('layouts.app')


@section('title', 'Расписание')

@section('content')
    <h1 class="text-center mb-4">Расписание</h1>

    @forelse($events as $event)
        <div class="mb-2 card">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-xl-2 p-0">
                        <img alt="Изображение мероприятия" data-lity src="{{ $event->imageUrl() }}"
                             class="h-100 w-100 card-img" style="object-fit: cover">
                    </div>
                    <div class="d-flex flex-column col-md-9 col-xl-10 py-2 px-3">
                        <div class="d-flex flex-row">
                            <div class="card-title h5 text-truncate" title="{{ $event->name }}">
                                {{ $event->name }}
                            </div>

                            @if($event->isTravel())
                                <div class="text-muted">
                                    @if($event->travel->type == \App\Enums\TravelType::Bike())
                                        <div class="ml-3" title="Это велосипедный поход" data-toggle="tooltip">
                                            <i class="fas fa-biking"></i>
                                        </div>
                                    @elseif($event->travel->type == \App\Enums\TravelType::Hiking())
                                        <div class="ml-3" title="Это пеший поход" data-toggle="tooltip">
                                            <i class="fas fa-hiking"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <h6 class="card-subtitle mb-2 text-muted">{{ $event->description }}</h6>
                        <p class="card-text mb-0"><b>Начало:</b> {{ $event->date_start->isoFormat('Do MMMM HH:mm') }}
                        </p>
                        <p class="card-text mb-0"><b>Окончание:</b> {{ $event->date_end->isoFormat('Do MMMM HH:mm') }}
                        </p>

                        @if($event->isTravel())
                            <p class="card-text mb-2"><b>Длина маршрута:</b> {{ $event->travel->distance }} км</p>
                        @endif

                        <div class="mt-auto">
                            <livewire:events.event-actions :event="$event"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
