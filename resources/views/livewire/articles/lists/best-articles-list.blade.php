<div>
    <livewire:articles.article-single :article="$articles->get(0)"/>

    <div class="row d-none d-md-flex">
        <div class="col-md-6 mt-3">
            <livewire:articles.article-single :article="$articles->get(1)"/>
        </div>

        <div class="col-md-6 mt-3">
            <livewire:articles.article-single :article="$articles->get(2)"/>
        </div>
    </div>
</div>
