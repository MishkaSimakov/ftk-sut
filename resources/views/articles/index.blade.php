@include('partials.header')

<div class="nav-scroller bg-white shadow-sm">
  <nav class="nav nav-underline">
    <a class="nav-link" href="{{ route('article.index') }}?filter=best">Лучшее</a>
    <a class="nav-link" href="{{ route('article.index') }}?filter=newest">Новейшее</a>
    @auth
    	@if (Auth::user()->isAdmin)
		    <a class="nav-link" href="{{ route('article.notPublished') }}">
		      Требуют проверки
		      <span class="badge badge-pill bg-light align-text-bottom">{{ $notPublishedCount }}</span>
		    </a>
	    @endif
    @endauth
  </nav>
</div>

<h1 class="text-center m-2">Статьи</h1>

@auth
    <h2 class="ml-2"><a href="{{ route('article.create') }}"><i class="fas fa-plus mr-1"></i>Написать статью</a></h2>
@endauth

<style>
  td {
    border: 2px solid lightgrey !important;
    border-collapse: collapse;
  }

  blockquote {
    border-left: 5px solid rgb(204, 204, 204);
    box-sizing: border-box;
    color: rgb(33, 37, 41);
    font-style: italic;
    margin-top: 12.96px;
    overflow-wrap: break-word;
    overflow-x: hidden;
    overflow-y: hidden;
    padding-left: 21.6px;
    text-align: left;
  }
</style>

@foreach($articles as $article)
	<div class="card m-2">
		<div class="card-header">
            <h1 class="d-inline-block m-0 p-0" title="{{ $article->title }}">
                {{ str_limit($article->title, 45, '...') }}

                @can('update', $article)
                    <a style="text-decoration: none" href="{{ route('article.edit', compact('article')) }}">
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
	    	<p>{!! $article->body !!}</p>
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


@auth
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
@endauth

@include('partials.footer')
