<div class="mb-2 card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xl-2 p-0">
                <img alt="Изображение мероприятия" data-lity src="{{ $event->imageUrl() }}"
                     class="h-100 w-100 card-img" style="object-fit: cover">
            </div>
            <div class="d-flex flex-column col-md-9 col-xl-10 py-2 px-3">
                <div class="card-title h5">
                    {{ $event->name }}
                </div>

                <h6 class="card-subtitle mb-2 text-muted">{{ $event->description }}</h6>
                <p class="card-text mb-0"><b>Начало:</b> {{ $event->date_start->isoFormat('Do MMMM HH:mm') }}</p>
                <p class="card-text mb-2"><b>Конец:</b> {{ $event->date_end->isoFormat('Do MMMM HH:mm') }}</p>

                <div class="mt-auto">
                    <livewire:events.event-actions :event="$event"/>
                </div>
            </div>
        </div>
    </div>
</div>
