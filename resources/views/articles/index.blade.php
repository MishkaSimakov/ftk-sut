@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Статьи</h1>

    @auth
        <h2 class="ml-2"><a href="{{ route('article.create') }}"><i class="fas fa-plus mr-1"></i>Написать статью</a></h2>
    @endauth

    <div class="m-3">
        @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
    </div>

    <div class="d-flex">
        <div class="mx-auto">
            {{ $articles->appends(['filter' => request()->get('filter')])->links() }}
        </div>
    </div>
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
