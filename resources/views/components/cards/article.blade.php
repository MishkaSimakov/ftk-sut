<div class="card shadow my-2">
    <div class="card-header d-flex flex-grow-1 px-1">
        <h4 class="col-md-8 text-truncate d-block font-weight-bold text-primary">
            <a title="{{ $article->title }}" href="{{ $article->url }}">
                {{ $article->title }}
            </a>
        </h4>

        <a class="d-none d-md-block ml-auto mr-2 text-muted" href="{{ $article->user->url }}">
            {{ $article->user->name }}
        </a>
    </div>

    <div class="card-body article__body">
        <div id="article_text" class="article__body-text">
            {!! $article->body !!}
        </div>

        <a id="article_read_more" style="display: none;" class="btn btn-outline-primary mt-2" title="Читать полностью" href="{{ $article->url }}">
            Читать полностью <i class="fa fa-arrow-right ml-1"></i>
        </a>

        @if($article->tags->count())
            <hr>

            <span class="mb-1">
                @foreach($article->tags as $tag)
                    <a href="?tag={{ $tag->name }}">
                        <span class="text-muted mr-2">{{ $tag->name }}</span>
                    </a>
                @endforeach
            </span>
        @endif
    </div>

    <div class="card-footer p-1">
        <div class="h3 my-auto mx-2 d-flex flex-grow-1">
            @if($article->is_published && !$article->is_blank)
                <article-actions url="{{ route('api.article.points', compact('article')) }}" auth="{{ auth()->check() }}" data="{{ $article->load(['comments', 'users'])->toJson() }}"></article-actions>
            @elseif($article->is_blank && $article->is_published)
                <a href="{{ route('article.edit', compact('article')) }}" class="btn btn-primary">Редактировать</a>
            @else
                @admin
                    <a href="#" onclick="event.preventDefault(); document.getElementById('publish-form-{{ $article->id }}').submit();" class="btn btn-primary">Опубликовать</a>

                    <form id="publish-form-{{ $article->id }}" action="{{ route('article.publish', compact('article')) }}" method="POST" class="d-none">
                        @method('PUT')
                        @csrf
                    </form>
                @endadmin
            @endif

            <span class="h5 my-auto text-muted ml-auto d-none d-sm-inline">
                {{ $article->created_at->locale('ru')->isoFormat('D MMMM Y') }}
            </span>
        </div>
    </div>
</div>
