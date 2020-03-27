<div class="card shadow m-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4 class="text-truncate d-block font-weight-bold text-primary">
            <a title="{{ $article->title }}" href="{{ $article->url }}">
                {{ $article->title }}
            </a>
        </h4>
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

    <div class="card-body">
        <p>
            {!! \Illuminate\Support\Str::limit($article->body, 825, '...') !!}
        </p>

        @if(strlen($article->body) > 825)
            <a title="{{ $article->title }}" href="{{ $article->url }}">
                Читать полностью
            </a>
        @endif

        @if($article->hasMedia())
            <p class="text-muted m-0">+{{ count($article->getMedia()) }} фото</p>
        @endif
    </div>

    <div class="card-footer p-1">
        <h3 class="my-auto ml-2">
            @if($article->is_published)
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
