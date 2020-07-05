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
@else
    <h2 class="text-center">Здесь ничего нет! 😯</h2>
@endif
