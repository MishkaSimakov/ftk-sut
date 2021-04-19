<div class="ml-auto row no-gutters">
    @can('like', $article)
        <div
            wire:click="$toggle('isLiked')"
            class="align-self-center mr-sm-2 mr-md-3"
            style="font-weight: 500; cursor: pointer"
        >
            @if($isLiked)
                <i class="fas fa-heart"></i>
            @else
                <i class="far fa-heart"></i>
            @endif

            {{ $article->points()->count() }}
        </div>
    @endcan

    <span class="align-self-center mr-sm-2 d-none d-md-inline" style="font-weight: 500;">
        <i class="far fa-eye"></i> {{ views($article)->count() }}
    </span>

    @canany(['update', 'delete'], $article)
        <div class="dropdown">
            <button class="d-inline btn rounded-pill text-muted" type="button"
                    id="article-more-dropdown-button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-h fa-sm"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="article-more-dropdown-button">
                @can('update', $article)
                    <a class="dropdown-item" href="{{ route('article.edit', $article) }}">Редактировать</a>
                @endcan
                @can('delete', $article)
                    <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteArticle">
                        Удалить
                    </a>
                @endcan
            </div>
        </div>
    @endcanany
</div>
