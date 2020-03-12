@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">
        {{ $article->title }}

        <div class="float-right">
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
        </div>
    </h1>

    <section class="section pb-1">
        <div class="container">
            <div class="mb-2">
                {!! $article->body !!}
            </div>

            @if($article->hasMedia())
                <hr>
                <div class="container">
                    @foreach($article->getMedia() as $photo)
                        <div class="col-md-2 m-2 p-0 d-inline-block">
                            <img class="mw-100 mh-100 rounded" src="/image/{{ $photo->getUrl() }}" style="cursor: pointer" data-lity data-lity-target="/image/{{ $photo->getUrl() }}">
                        </div>
                    @endforeach
                </div>
            @endif

            <hr>

            <h3 class="my-auto">
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
            </h3>
        </div>
    </section>
@endsection

@push('script')
    @auth
        <script type="text/javascript">
            function like(article) {
                var counter = $('.point_count' + article);

                counter.html(Number(counter.html()) + 1);

                $('#like_' + article).attr('class', 'article__liked');

                $.ajax({
                    url: "{{ route('api.article.points') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        article_id: article,
                        type: 'like'
                    },
                    success: function (data) {
                        if (data === 'error') {
                            alert('О нет! Что-то не так!');
                            window.location.reload()
                        }
                    }
                });
            }

            function unlike(article) {
                var counter = $('.point_count' + article);

                counter.html(Number(counter.html()) - 1);

                $('#like_' + article).attr('class', 'article__unliked');

                $.ajax({
                    url: "{{ route('api.article.points') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        article_id: article,
                        type: 'unlike'
                    },
                    success: function (data) {
                        if (data === 'error') {
                            alert('О нет! Что-то не так!');
                            window.location.reload()
                        }
                    }
                });
            }
        </script>
    @endauth
@endpush
