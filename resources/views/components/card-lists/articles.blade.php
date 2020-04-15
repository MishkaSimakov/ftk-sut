@if($articles->count())
    @foreach($articles as $article)
        @component('components.cards.article', ['article' => $article])@endcomponent
    @endforeach
@else
    <h2 class="text-center">Здесь ничего нет! 😯</h2>
@endif
