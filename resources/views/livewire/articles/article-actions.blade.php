<div class="row no-gutters align-items-center">
    @can('like', $article)
        <div
            id="article_{{ $article->id }}_like_button"
            onclick="@this.toggleLike(); toggleLikeDebounced({{ $article->id }})"
            class="mr-sm-2 mr-md-3 article-like-button {{ $article->isLikedBy(auth()->user()) ? 'liked' : '' }}"
        >
            <i class="{{ $article->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
            <span> {{ $article->points()->count() }}</span>
        </div>
    @endcan

    @if($article->type == \App\Enums\ArticleType::Published())
        <span class="mr-sm-2 d-none d-md-inline article-views">
            <i class="far fa-eye"></i> {{ $article->views_count ?? views($article)->count() }}
        </span>
    @endif

    @canany(['update', 'delete'], $article)
        <div class="dropdown">
            <button class="d-inline btn rounded-pill text-muted" type="button"
                    id="article-more-dropdown-button-{{ $article->id }}"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Дополнительно">
                <i class="fas fa-ellipsis-h fa-sm"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="article-more-dropdown-button-{{ $article->id }}">
                @can('publish', $article)
                    <a class="dropdown-item" href="{{ route('article.publish', $article) }}">Опубликовать</a>
                @endcan
                @can('update', $article)
                    <a class="dropdown-item" href="{{ route('article.edit', $article) }}">Редактировать</a>
                @endcan
                @can('delete', $article)
                    <a
                        class="dropdown-item text-danger"
                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $article->id }}').submit();"
                        href="#"
                    >
                        Удалить
                    </a>
                    <form method="POST" id="delete-form-{{ $article->id }}"
                          action="{{ route('article.destroy', $article) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                @endcan
            </div>
        </div>
    @endcanany
</div>

@once
    @push('scripts')
        <script>
            function toggleLike(article_id) {
                let element = document.getElementById(`article_${article_id}_like_button`);
                element.classList.toggle("liked");

                if (element.classList.contains('liked')) {
                    element.children[0].classList.add('fas')
                    element.children[1].innerText = parseInt(element.innerText) + 1
                } else {
                    element.children[0].classList.add('far')
                    element.children[1].innerText = parseInt(element.innerText) - 1
                }
            }

            function debounce(f, ms) {
                let isCooldown = false;

                return function () {
                    if (isCooldown) return;

                    f.apply(this, arguments);
                    isCooldown = true;
                    setTimeout(() => isCooldown = false, ms);
                };
            }

            let toggleLikeDebounced = debounce(toggleLike, 1000);
        </script>
    @endpush
@endonce
