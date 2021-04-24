<div>
    @foreach($news as $n)
        <livewire:news.news-single :news="$n" :key="$n->id"/>
    @endforeach

    <div class="row no-gutters">
        <div class="mx-auto">
            {{ $news->links() }}
        </div>
    </div>
</div>
