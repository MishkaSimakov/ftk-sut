<div class="card shadow m-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4 class="text-truncate d-block font-weight-bold text-primary">
            <a class="" title="{{ $article->title }}" href="{{ $article->url }}">
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
        <p>{!! \Illuminate\Support\Str::limit($article->body, 750, '...') !!}</p>

        @if($article->hasMedia())
            <p class="text-muted m-0">+{{ count($article->getMedia()) }} фото</p>
        @endif
    </div>

    <div class="card-footer p-1">
        <h3 class="my-auto ml-2">
              <span id="like_{{ $article->id }}">
                  @auth
                      @if ($article->isLiked)
                          <a style="color: rgb(255, 51, 71) !important;" id="link" onclick="unlike({{ $article->id }})"><i style="cursor: pointer;" class="fas fa-heart"></i></a>
                      @else
                          <a style="color: rgb(130, 138, 153) !important;" id="link" onclick="like({{ $article->id }})"><i style="cursor: pointer;" class="far fa-heart"></i></a>
                      @endif
                  @else
                      <i style="color: rgb(130, 138, 153) !important;" class="fas fa-heart"></i>
                  @endauth
              </span>

            <span style="color: rgb(130, 138, 153) !important;" class="point_count{{ $article->id }}">{{ $article->points }}</span>
        </h3>
    </div>
</div>
