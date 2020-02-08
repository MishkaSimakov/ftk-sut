<div class="card m-2">
    <div class="card-header">
        <h1 class="d-inline-block m-0 p-0">
            <a title="{{ $article->title }}" href="{{ $article->url }}">{{ \Illuminate\Support\Str::limit($article->title, 45, '...') }}</a>

            @can('update', $article)
                <a title="Редактировать" class="text-decoration-none" href="{{ route('article.edit', compact('article')) }}">
                    <span class="fa-xs ml-2 fas fa-cog"></span>
                </a>
            @endcan
            @can('delete', $article)
                <a title="Удалить" class="text-primary" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $article->id }}').submit();">
                    <span class="fa-xs ml-2 fas fa-trash"></span>
                </a>

                <form method="POST" action="{{ route('article.destroy', compact('article')) }}" id="delete-form-{{ $article->id }}">
                    @csrf
                    @method("DELETE")
                </form>
            @endcan
        </h1>

        <h4 class=" m-2 d-inline-block float-right"><a href="{{ $article->user->url }}">{{ $article->user->name }}</a></h4>
    </div>

    <div class="card-body">
        <p>{!! \Illuminate\Support\Str::limit($article->body, 750, '...') !!}</p>

        @if($article->hasMedia())
            <p class="text-muted m-0">+{{ count($article->getMedia()) }} фото</p>
        @endif
    </div>

    <div class="card-footer p-1">
        <h3 class="mt-2 ml-2">
              <span id="like_{{ $article->id }}">
                  @auth
                      @if ($article->isLiked)
                          <a id="link" onclick="unlike({{ $article->id }})"><i style="cursor: pointer;" class="text-primary fas fa-heart"></i></a>
                      @else
                          <a id="link" onclick="like({{ $article->id }})"><i style="cursor: pointer;" class="text-primary far fa-heart"></i></a>
                      @endif
                  @else
                      <i class="text-primary fas fa-heart"></i>
                  @endauth
              </span>

            <span class="point_count{{ $article->id }}">{{ $article->points }}</span>
        </h3>
    </div>
</div>


{{--<div class="shadow rounded-lg p-3 mt-3 m-2">--}}
{{--    <div class="">--}}
{{--        <h1 class="d-inline-block m-0 p-0">--}}
{{--            <a title="{{ $article->title }}" href="{{ $article->url }}">{{ \Illuminate\Support\Str::limit($article->title, 45, '...') }}</a>--}}

{{--            @can('update', $article)--}}
{{--                <a title="Редактировать" class="text-decoration-none" href="{{ route('article.edit', compact('article')) }}">--}}
{{--                    <span class="fa-xs ml-2 fas fa-cog"></span>--}}
{{--                </a>--}}
{{--            @endcan--}}
{{--            @can('delete', $article)--}}
{{--                <a title="Удалить" class="text-primary" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">--}}
{{--                    <span class="fa-xs ml-2 fas fa-trash"></span>--}}
{{--                </a>--}}

{{--                <form method="POST" action="{{ route('article.destroy', compact('article')) }}" id="delete-form">--}}
{{--                    @csrf--}}
{{--                    @method("DELETE")--}}
{{--                </form>--}}
{{--            @endcan--}}
{{--        </h1>--}}

{{--        <h4 class=" m-2 d-inline-block float-right"><a href="{{ $article->user->url }}">{{ $article->user->name }}</a></h4>--}}
{{--    </div>--}}

{{--    <hr>--}}

{{--    <div class="">--}}
{{--        <p>{!! \Illuminate\Support\Str::limit($article->body, 500, '...') !!}</p>--}}

{{--        @if($article->hasMedia())--}}
{{--            <p class="text-muted m-0">+{{ count($article->getMedia()) }} фото</p>--}}
{{--        @endif--}}
{{--    </div>--}}

{{--    <div class="p-1">--}}
{{--        <h3>--}}
{{--              <span id="like_{{ $article->id }}">--}}
{{--                  @auth--}}
{{--                      @if ($article->isLiked)--}}
{{--                          <a id="link" onclick="unlike({{ $article->id }})"><i style="cursor: pointer;" class="text-primary fas fa-heart"></i></a>--}}
{{--                      @else--}}
{{--                          <a id="link" onclick="like({{ $article->id }})"><i style="cursor: pointer;" class="text-primary far fa-heart"></i></a>--}}
{{--                      @endif--}}
{{--                  @else--}}
{{--                      <i class="text-primary fas fa-heart"></i>--}}
{{--                  @endauth--}}
{{--              </span>--}}

{{--            <span class="point_count{{ $article->id }}">{{ $article->points }}</span>--}}
{{--        </h3>--}}
{{--    </div>--}}
{{--</div>--}}
