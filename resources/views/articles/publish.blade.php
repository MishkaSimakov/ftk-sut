@extends('layouts.page')

@section('content')

@include('partials.articles.header')

<h1 class="text-center m-2">Требуют проверки</h1>

@foreach($articles as $article)
	<div class="card m-2">
		<div class="card-header">
			<h1>{{ $article->title }}</h1>
		</div>

		<div class="card-body">
	    	<p>{!! $article->body !!}</p>

            @foreach($article->getMedia() as $photo)
                <div class="col-md-1 m-2 p-0 d-inline-block">
                    <img class="mw-100 mh-100 rounded" src="{{ $photo->path }}" style="cursor: pointer" data-lity data-lity-target="{{ $photo->path }}">
                </div>
            @endforeach
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

@endsection
