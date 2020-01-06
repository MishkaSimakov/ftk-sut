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

    @component('components.sections.section', ['header' => ''])
        <div class="mb-2">
            {!! $article->body !!}
        </div>

        @if($article->hasMedia())
            <h2 class="ml-2">Галерея:</h2>

            <div class="container">
                @foreach($article->getMedia() as $photo)
                    <div class="col-md-2 m-2 p-0 d-inline-block">
                        <img class="mw-100 mh-100 rounded" src="{{ $photo->path }}" style="cursor: pointer" data-lity data-lity-target="{{ $photo->path }}">
                    </div>
                @endforeach
            </div>
        @endif

        <h3 class="m-0">
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
    @endcomponent
@endsection

@push('script')
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
@endpush
