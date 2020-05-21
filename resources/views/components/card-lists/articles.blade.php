@if($articles->count())
    @foreach($articles as $article)
        @component('components.cards.article', ['article' => $article])@endcomponent
    @endforeach

    @push('script')
        <script type="text/javascript">
            $(document).ready(function() {
                $('img').each(function () {
                    $(this).addClass('mw-100 h-auto');
                });
                $('blockquote').each(function () {
                    $(this).addClass('pl-3 my-1 blockquote');
                    $(this).attr('style', 'border-left: 3px solid lightgray;')
                });
                $('.article__body').each(function () {
                    if ($(this).children('#article_text').height() >= 500) {
                        $(this).children('#article_read_more').show()
                    }
                })
            });
        </script>
    @endpush

    @auth
        @push('script')
            <script type="text/javascript">
                function like(article) {
                    let counter = $('.point_count' + article)
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
                    let counter = $('.point_count' + article)
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
@else
    <h2 class="text-center">Здесь ничего нет! 😯</h2>
@endif
