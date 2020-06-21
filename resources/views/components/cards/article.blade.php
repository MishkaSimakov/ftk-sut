<div class="card shadow m-2">
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
{{--                TODO: make this as vue component--}}
                @auth
                    <span class="{{ $article->is_liked ? 'article__liked' : 'article__unliked' }}" id="like_{{ $article->id }}">
                        <a class="article__unlike_link" id="link" onclick="unlike({{ $article->id }})"><i style="cursor: pointer;" class="fas fa-heart"></i></a>
                        <a class="article__like_link" id="link" onclick="like({{ $article->id }})"><i style="cursor: pointer;" class="far fa-heart"></i></a>

                        <span class="article__like_counter point_count{{ $article->id }}">{{ $article->points }}</span>
                    </span>
                @else
                    <span class="article__liked" id="like_{{ $article->id }}">
                        <i class="article__unlike_link fas fa-heart"></i>

                        <span class="article__like_counter">{{ $article->points }}</span>
                    </span>
                @endauth

                <div class="ml-4 d-inline-block">
                    <a href="{{ $article->url }}#comments" class="article__comment_link">
                        <i style="cursor: pointer;" class="far fa-comment"></i>
                    </a>

                    <span class="article__comments_counter">{{ $article->comments->count() }}</span>
                </div>

                <div class="ml-4 d-inline-block">
                    <a class="article__comment_link">
                        <i class="far fa-eye"></i>
                    </a>

                    <span class="article__comments_counter">{{ views($article)->count() }}</span>
                </div>
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

            <span class="h5 my-auto text-muted ml-auto">{{ $article->created_at->locale('ru')->isoFormat('D MMMM Y') }}</span>
        </div>
    </div>
</div>
