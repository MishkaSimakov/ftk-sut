@include('partials.header')

<div class="nav-scroller bg-white shadow-sm">
  <nav class="nav nav-underline">
    <a class="nav-link" href="{{ route('article.index') }}?filter=best">Лучшее</a>
    <a class="nav-link" href="{{ route('article.index') }}?filter=newest">Новейшее</a>
    @auth
    	@if (Auth::user()->is_admin)
		    <a class="nav-link" href="{{ route('article.notPublished') }}">
		      Требуют проверки
		      <span class="badge badge-pill bg-light align-text-bottom">{{ $notPublishedCount }}</span>
		    </a>
	    @endif
    @endauth
  </nav>
</div>

<h1 class="text-center m-2">Требуют проверки</h1>

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
			<h1>{{ $article->title }}</h1>
		</div>
		<div class="card-body">
	    	<p>{!! $article->body !!}</p>
		</div>

    <div class="card-footer">
      <a href="#" onclick="event.preventDefault(); document.getElementById('publish-form').submit();" class="btn btn-primary">Опубликовать</a>
      <a href="{{ $article->delete }}" onclick="event.preventDefault(); document.getElementById('delete-form').submit();" class="btn btn-danger">Удалить</a>
    </div>
	</div>

  <form id="publish-form" action="{{ $article->publish }}" method="POST" class="d-none">
    @method('PUT')
    @csrf
  </form>

  <form id="delete-form" action="{{ $article->delete }}" method="POST" class="d-none">
    @method('DELETE')
    @csrf
  </form>
@endforeach

@include('partials.footer')
