<div class="row">
    @foreach($news as $current_news)
        <div class="container">
            @component('components.cards.news', ['current_news' => $current_news])@endcomponent
        </div>
    @endforeach
</div>
