<div class="mb-2 card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xl-2 p-0">
                <img alt="Изображение мероприятия" data-lity src="{{ $event->imageUrl() }}"
                     class="h-100 w-100 card-img" style="object-fit: cover">
            </div>
            <div class="d-flex flex-column col-md-9 py-2 px-3">
                <div class="card-title h5">
                    {{ $event->name }}
                </div>

                <h6 class="card-subtitle mb-2 text-muted">{{ $event->description }}</h6>
                <p class="card-text mb-0"><b>Начало:</b> {{ $event->date_start->isoFormat('Do MMMM HH:mm') }}</p>
                <p class="card-text mb-2"><b>Конец:</b> {{ $event->date_end->isoFormat('Do MMMM HH:mm') }}</p>

                <div class="mt-auto">
                    @can('signUp', $event)
                        @if($event->isUserSignedUp(auth()->user()))
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        wire:loading.attr="disabled" wire:target="signOut"
                                >
                                    Вы записаны
                                    <span
                                        wire:loading wire:target="signOut"
                                        class="spinner-border text-white spinner-border-sm ml-2"
                                        role="status"
                                    ></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                       data-target="#{{ $modal_id }}">Кто пойдёт?</a>
                                    <a class="dropdown-item" href="#" wire:click="signOut">Меня не будет</a>
                                </div>
                            </div>
                        @else
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" wire:click="signUp"
                                        wire:loading.attr="disabled" wire:target="signUp">
                                    Записаться
                                    <span
                                        wire:loading wire:target="signUp"
                                        class="spinner-border text-white spinner-border-sm ml-2"
                                        role="status"
                                    ></span>
                                </button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        wire:loading.attr="disabled" wire:target="signUp"
                                ></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                       data-target="#{{ $modal_id }}">Кто пойдёт</a>
                                </div>
                            </div>
                        @endif
                    @else
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#{{ $modal_id }}">
                            Кто пойдёт?
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $event->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-weight-bold">Список пользователей:</p>
                    @foreach($event->users as $user)
                        <a href="{{ $user->url }}">{{ $user->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
