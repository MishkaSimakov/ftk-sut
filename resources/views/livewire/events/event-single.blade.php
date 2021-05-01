<div class="mb-2 card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xl-2 p-0">
                <img alt="Изображение мероприятия" data-lity src="{{ $event->imageUrl() }}"
                     class="h-100 w-100 card-img" style="cursor: pointer; object-fit: cover">
            </div>
            <div class="d-flex flex-column col-md-9 py-2 px-3">
                <div class="card-title h5">
                    {{ $event->name }}
                </div>

                <h6 class="card-subtitle mb-2 text-muted">{{ $event->description }}</h6>
                <p class="card-text mb-0"><b>Начало:</b> {{ $event->date_start->isoFormat('Do MMMM HH:mm') }}</p>
                <p class="card-text mb-2"><b>Конец:</b> {{ $event->date_end->isoFormat('Do MMMM HH:mm') }}</p>

                <div class="mt-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" wire:click="signUp">Записаться</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Кто пойдёт</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
