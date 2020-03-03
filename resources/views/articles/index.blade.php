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
                var counter = $('.point_count' + article)

                counter.html(Number(counter.html()) + 1);

                $('#like_' + article).attr('class', 'article__liked')

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
                            alert('О нет! Что-то не так!')
                            window.location.reload()
                        }
                    }
                });
            }

            function unlike(article) {
                var counter = $('.point_count' + article)

                counter.html(Number(counter.html()) - 1);

                $('#like_' + article).attr('class', 'article__unliked')

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
                            alert('О нет! Что-то не так!')
                            window.location.reload()
                        }
                    }
                });
            }
        </script>
    @endpush
@endauth
