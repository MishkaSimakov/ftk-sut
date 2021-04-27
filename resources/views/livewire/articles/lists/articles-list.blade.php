<div wire:init="loadMore">
    @foreach($this->articles as $article)
        <livewire:articles.article-single :article="$article" :key="$article->id"/>
    @endforeach
</div>

@push('scripts')
    <script>
        window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                @this.loadMore();
            }
        };
    </script>
@endpush
