@extends('layouts.page')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1 class="my-2">Статьи</h1>

            @auth
                <span class="h3 my-auto ml-3">
                    <a title="Написать статью" href="{{ route('article.create') }}">
                        <i class="fas fa-pen"></i>
                    </a>
                </span>
            @endauth
        </div>

        <find-articles-form></find-articles-form>

        <div class="row">
            <div class="mt-2 col-lg-8">
                @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
            </div>

            <div id="sidebar" class="col-lg-4 mt-2 d-none d-lg-block">
                <writers-top></writers-top>
            </div>
        </div>
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
            $(document).ready(function() {
                $('.article__body').each(function () {
                    if ($(this).children('#article_text').height() >= 500) {
                        $(this).children('#article_read_more').show()
                    }
                })
            });

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
                            alert('😖О нет! Что-то не так!😖');
                            window.location.reload();
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
                            alert('😖О нет! Что-то не так!😖');
                            window.location.reload();
                        }
                    }
                });
            }
        </script>
    @endpush
@endauth
