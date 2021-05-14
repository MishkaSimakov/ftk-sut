<div>
    @foreach($articles as $article)
        <livewire:articles.article-single :article="$article" :key="$article->id"/>
    @endforeach

    @if($hasMorePages)
        <div class="d-flex flex-row">
            <button type="button" class="mx-auto btn btn-primary" wire:click="loadMore" wire:loading.remove
                    wire:target="loadMore">
                Загрузить ещё
            </button>
            <button type="button" class="mx-auto btn btn-primary disabled" wire:loading wire:target="loadMore" disabled>
                <div class="spinner-border spinner-border-sm" role="status"></div>
            </button>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            window.onscroll = function (ev) {
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && @this.hasMorePages) {
                    @this.loadMore();
                }
            };
        })
    </script>
@endpush
