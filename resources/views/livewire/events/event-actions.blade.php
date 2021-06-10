<div class="mt-3 row no-gutters align-items-center">
    <div>
        @can('signUp', $event)
            @if($event->isUserSignedUp(auth()->user()))
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button"
                            id="dropdownMenuButton"
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
                    <button type="button"
                            class="btn btn-primary dropdown-toggle dropdown-toggle-split"
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
            <button type="button" class="btn btn-info" data-toggle="modal"
                    data-target="#{{ $modal_id }}">
                @if($event->isPast())
                    Список участников
                @else
                    Кто пойдёт?
                @endif
            </button>
        @endcan
    </div>

    @canany(['update', 'delete'], $event)
        <div class="dropdown ml-auto">
            <button class="d-inline btn rounded-pill text-muted" type="button"
                    id="event-more-dropdown-button-{{ $event->id }}"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    aria-label="Дополнительно">
                <i class="fas fa-ellipsis-h fa-sm"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right"
                 aria-labelledby="event-more-dropdown-button-{{ $event->id }}">
                @can('changeUsersList', $event)
                    <a class="dropdown-item" href="{{ route('events.users.edit', $event) }}">Редактировать список
                        пользователей</a>
                @endcan
                @can('update', $event)
                    <a class="dropdown-item" href="{{ route('events.edit', $event) }}">Редактировать</a>
                @endcan
                @can('delete', $event)
                    <a
                        class="dropdown-item text-danger"
                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $event->id }}').submit();"
                        href="#"
                    >
                        Удалить
                    </a>
                    <form method="POST" id="delete-form-{{ $event->id }}"
                          action="{{ route('events.destroy', $event) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                @endcan
            </div>
        </div>
    @endcanany

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
                    @if($event->users->count())
                        <p class="h6">Список участников:</p>

                        <ol>
                            @foreach($event->users as $user)
                                <li>
                                    <a href="{{ $user->url }}">{{ $user->name }}</a>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="my-3 text-center h6 text-info">
                            Ещё никто не записывался на это мероприятие
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
