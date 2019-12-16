@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Статьи</h1>

    @auth
        <h2 class="ml-2"><a href="{{ route('article.create') }}"><i class="fas fa-plus mr-1"></i>Написать статью</a></h2>
    @endauth

    @foreach($articles as $article)
        <div class="card m-2">
            <div class="card-header">
                <h1 class="d-inline-block m-0 p-0" title="{{ $article->title }}">
                    <a href="{{ route('article.show', compact('article')) }}">{{ str_limit($article->title, 45, '...') }}</a>

                    @can('update', $article)
                        <a class="text-decoration-none" href="{{ route('article.edit', compact('article')) }}">
                            <span class="fa-xs ml-2 fas fa-cog"></span>
                        </a>
                    @endcan
                    @can('delete', $article)
                        <a class="text-primary" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                            <span class="fa-xs ml-2 fas fa-trash"></span>
                        </a>

                        <form method="POST" action="{{ route('article.destroy', compact('article')) }}" id="delete-form">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endcan
                </h1>

            <h4 class=" m-2 d-inline-block float-right"><a href="{{ $article->user->url }}">{{ $article->user->name }}</a></h4>
            </div>

            <div class="card-body">
                <p>{{ str_limit($article->body, 500, '...') }}</p>

                @if($article->hasMedia())
                    <p class="text-muted m-0">+{{ count($article->getMedia()) }} фото</p>
                @endif
            </div>

        @auth
          <div class="card-footer p-0">
            <h3 class="mt-2 ml-2">
              <span id="like_{{ $article->id }}">
                @if ($article->isLiked)
                  <a id="link" onclick="unlike({{ $article->id }})"><i style="cursor: pointer;" class="text-primary fas fa-heart"></i></a>
                @else
                  <a id="link" onclick="like({{ $article->id }})"><i style="cursor: pointer;" class="text-primary far fa-heart"></i></a>
                @endif
              </span>

              <span class="point_count{{ $article->id }}">{{ $article->points }}</span>
            </h3>
          </div>
        @endauth
       </div>
    @endforeach

    @if ($articles->count())
        <div class="text-center d-inline-block w-100">
            {{ $articles->appends(['filter' => request()->get('filter')])->links() }}
        </div>
    @endif
@endsection

@auth
    @push('script')
        <script type="text/javascript">
            function like(article) {
                $('.point_count' + article).html(Number($('.point_count' + article).html()) + 1);

                $('#like_' + article).html('<a id="link" onclick="unlike(' + article +')"><i style="cursor: pointer;" class="text-primary fas fa-heart"></i></a>');

                $.ajax({
                    url: "{{ route('api.article.points') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        article_id: article,
                        type: 'like'
                    }
                });
            }

            function unlike(article) {
                $('.point_count' + article).html(Number($('.point_count' + article).html()) - 1);

                $('#like_' + article).html('<a id="link" onclick="like(' + article + ')"><i style="cursor: pointer;" class="text-primary far fa-heart"></i></a>');

                $.ajax({
                    url: "{{ route('api.article.points') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        article_id: article,
                        type: 'unlike'
                    }
                });
            }
        </script>
    @endpush
@endauth
