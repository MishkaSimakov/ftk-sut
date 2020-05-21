@extends('layouts.page', ['title' => $article->title])

@section('content')
    <div class="container">
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

        <div class="card shadow mt-3">
            <div class="card-body">
                <div>
                    {!! $article->body !!}
                </div>

                @if($article->tags->count())
                    <hr>
                    <span class="mb-1">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('article.index') }}?tag={{ $tag->name }}">
                                <span class="text-muted mr-2">{{ $tag->name }}</span>
                            </a>
                        @endforeach
                    </span>
                @endif
            </div>

            <div class="card-footer p-1">
                <h3 class="my-auto ml-2">
                    @if($article->is_published && !$article->is_blank)
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

        @if($article->is_published && !$article->is_blank)
            <comments article_id="{{ $article->id }}"></comments>
        @endif
    </div>
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

    <script>
        $('blockquote').each(function () {
            $(this).addClass('pl-3 my-1 blockquote');
            $(this).attr('style', 'border-left: 3px solid lightgray;')
        });
        $('img').each(function () {
            $(this).on('click', lity);
            $(this).addClass('mw-100 h-auto');
            $(this).attr('style', 'cursor: pointer;')
        });
    </script>
@endpush
