<div>
    @if($articles->count() >= 3)
        <livewire:articles.article-single :article="$articles->get(0)"/>

        <div class="row d-none d-md-flex">
            <div class="col-md-6 mt-3">
                <livewire:articles.article-single :article="$articles->get(1)"/>
            </div>

            <div class="col-md-6 mt-3">
                <livewire:articles.article-single :article="$articles->get(2)"/>
            </div>
        </div>
    @else
        <p class="text-info text-center">Недостаточно статей</p>
    @endif
</div>
