@foreach($news as $current_news)
    @component('components.cards.news', ['current_news' => $current_news])@endcomponent
@endforeach
