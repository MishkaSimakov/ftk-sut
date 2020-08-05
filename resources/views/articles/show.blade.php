@extends('layouts.page', ['title' => $article->title])

@section('content')
    <div class="container">
        <h1 class="mt-2 mx-auto text-center">
            {{ $article->title }}
        </h1>

        <div class="card mt-3">
            <div class="card-body">
                <div class="float-right">
                    @can('update', $article)
                        <a class="text-decoration-none" href="{{ route('article.edit', compact('article')) }}">
                            <span class="ml-2 fas fa-cog"></span>
                        </a>
                    @endcan
                    @can('delete', $article)
                        <a class="text-danger" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                            <span class="ml-1 fas fa-trash"></span>
                        </a>

                        <form method="POST" action="{{ route('article.destroy', compact('article')) }}" id="delete-form">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endcan
                </div>

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
        </div>

        <div class="card mt-2 p-1">
            <div class="h3 my-auto mx-2 d-flex flex-grow-1">
                @if($article->is_published && !$article->is_blank)
                    <article-actions url="{{ route('api.article.points', compact('article')) }}" auth="{{ auth()->check() }}" data="{{ $article->toJson() }}"></article-actions>
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

                <span class="h5 my-auto text-muted ml-auto d-none d-sm-inline">
                    {{ $article->created_at->locale('ru')->isoFormat('D MMMM Y') }}
                </span>
            </div>
        </div>

        @if($article->is_published && !$article->is_blank)
            <comments article_id="{{ $article->id }}"></comments>
        @endif
    </div>
@endsection

@push('script')
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

@push('side')
    @component('components.navs.article')@endcomponent
@endpush
