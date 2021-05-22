<div>
    <p class="mb-4 h6">Список пользователей:</p>

    <form action="" wire:submit.prevent="addUser">
        <div class="form-row">
            <div class="col">
                <select class="form-control custom-select" wire:model.defer="selected_user">
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
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered border-top-0 border-bottom-0 m-0">
                        <thead>
                        <tr>
                            <th>Фамилия, имя</th>
                            @if($event->isTravel())
                                <th>Расстояние (км)</th>
                            @endif
                            <th>Действия</th>
                        </tr>
                        </thead>
                        @foreach($event->users as $user)
                            <tbody>
                            <tr wire:key="{{ $user->id }}">
                                <td class="align-middle">
                                    <a href="{{ $user->url }}" class="text-nowrap">{{ $user->name }}</a>
                                </td>
                                @if($event->isTravel())
                                    <td>
                                        <input type="number" step="0.1" min="0"
                                               wire:model.defer="users_distances.{{ $user->id }}">
                                    </td>
                                @endif
                                <td>
                                    <button
                                        type="button" class="btn-danger btn" title="Удалить пользователя из мероприятия"
                                        wire:click.prevent="removeUser({{ $user->id }})"
                                        wire:loading.remove wire:target="removeUser({{ $user->id }})"
                                    >
                                        Удалить
                                    </button>
                                    <button
                                        type="button" class="btn-danger btn"
                                        wire:loading wire:target="removeUser({{ $user->id }})"
                                    >
                                        <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                                    </button>


                                    <div wire:target="users_distances.{{ $user->id }}" wire:dirty>
                                        <button
                                            type="button" class="btn-primary btn" title="Сохранить изменения"
                                            wire
                                            wire:click.prevent="changeUserDistance({{ $user->id }})"
                                            wire:loading.remove wire:target="changeUserDistance({{ $user->id }})"
                                        >
                                            Сохранить
                                        </button>
                                        <button
                                            type="button" class="btn-primary btn"
                                            wire:loading wire:target="changeUserDistance({{ $user->id }})"
                                        >
                                            <div class="spinner-border spinner-border-sm text-white"
                                                 role="status"></div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        @else
            <div class="my-3 h6 text-info">
                <span>Ещё никто не записывался на это мероприятие.</span>
            </div>
        @endif
    </form>
</div>
