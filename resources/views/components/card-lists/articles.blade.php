@foreach($articles as $article)
{{--    <div class="container">--}}
        @component('components.cards.article', ['article' => $article])@endcomponent
{{--    </div>--}}
@endforeach
