@foreach($articles as $article)
    @component('components.cards.article', ['article' => $article])@endcomponent
@endforeach
