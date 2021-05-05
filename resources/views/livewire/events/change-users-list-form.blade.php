<div>
    <p class="mb-4 h6">Список пользователей:</p>

    <form action="">
        <div class="form-row">
            <div class="col">
                <select class="form-control" wire:model.defer="selected_user">
                    <option value="-1">Выберите пользователя</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary mb-2" wire:click.prevent="addUser" wire:loading.remove
                        wire:target="addUser">
                    Добавить
                </button>
                <button type="button" class="btn btn-primary mb-2 disabled" wire:loading wire:target="addUser" disabled>
                    <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                </button>
            </div>
        </div>

        @if($event->users->count())
            <ol>
                @foreach($event->users as $user)
                    <li class="col-xl-3 col-lg-4 col-md-6 col-sm-9" wire:key="{{ $user->id }}">
                        <a href="{{ $user->url }}">{{ $user->name }}</a>
                        <button
                            type="button" class="close" title="Удалить пользователя из мероприятия"
                            wire:click.prevent="removeUser({{ $user->id }})"
                            wire:loading.remove wire:target="removeUser({{ $user->id }})"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <div
                            class="spinner-border spinner-border-sm text-muted float-right my-auto" role="status"
                            wire:loading wire:target="removeUser({{ $user->id }})"
                        ></div>
                    </li>
                @endforeach
            </ol>
        @else
            <div class="my-3 h6 text-info">
                <span>Ещё никто не записывался на это мероприятие.</span>
            </div>
        @endif
    </form>
</div>
