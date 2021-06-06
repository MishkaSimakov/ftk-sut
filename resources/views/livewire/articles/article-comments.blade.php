<div>
    <hr>

    @auth
        <form wire:submit.prevent="send">
            <div class="input-group">
                <input
                    placeholder="Написать комментарий..." type="text"
                    id="add_comment_input" class="form-control"
                    wire:model.lazy="comment"
                >

                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary">
                        Отправить
                    </button>
                </div>
            </div>
        </form>
    @endauth

    <div>
        @forelse($comments as $comment)
            <div class="d-flex flex-row mt-3">
                <div class="w-100">
                    <div class="row no-gutters">
                        <h5>
                            {{ $comment->user->name }}
                        </h5>
                        <span class="text-muted ml-sm-auto col-12 col-sm-auto">{{ $comment->created_at->isoFormat('ll HH:mm') }}</span>
                    </div>

                    <p>
                        {{ $comment->body }}
                    </p>
                </div>
            </div>
        @empty
            <div class="my-3 text-center h6 text-info">
                Нет комментариев
            </div>
        @endforelse
    </div>
</div>
