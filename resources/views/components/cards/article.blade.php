<div class="card shadow m-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4 class="col-md-8 text-truncate d-block font-weight-bold text-primary">
            <a title="{{ $article->title }}" href="{{ $article->url }}">
                {{ $article->title }}
            </a>
        </h4>
        <div class="float-right row">
            <a class="d-none d-md-block text-gray-400 mr-3" href="{{ $article->user->url }}">
                {{ $article->user->name }}
            </a>
            <div class="dropdown no-gutters">
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header font-weight-bold">Дополнительно:</div>
                    <a class="dropdown-item" href="{{ $article->user->url }}">{{ $article->user->name }}</a>

                    @can('update', $article)
                        <a class="dropdown-item" href="{{ route('article.edit', compact('article')) }}">
                            Редактировать
                        </a>
                    @endcan

                    @can('delete', $article)
                        <div class="dropdown-divider"></div>

                        <a style="cursor: pointer" class="text-danger dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $article->id }}').submit();">
                            Удалить
                        </a>

                        <form method="POST" action="{{ route('article.destroy', compact('article')) }}" id="delete-form-{{ $article->id }}">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endcan
                </div>
            </div>
        </div>
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
        <h3 class="my-auto ml-2">
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

            <span class="font-weight-light text-gray-500 float-right mr-3">{{ $article->created_at->locale('ru')->isoFormat('D MMMM Y') }}</span>
        </h3>
    </div>
</div>
