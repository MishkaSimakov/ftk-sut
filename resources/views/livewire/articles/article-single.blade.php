<div class="card h-100 mb-3 {{ $article->isPublished ? '' : 'text-secondary' }}">
    <div class="card-body pb-2 d-flex flex-column">
        <div style="transform: translate(0)">
            <h5 class="card-title">
                <a href="{{ $article->url }}" class="stretched-link article-title-link">{{ $article->title }}</a>
            </h5>
            <div class="card-text">
                {!! $article->truncated_body !!}
            </div>
        </div>

        <div class="row no-gutters mt-auto text-muted align-items-center">
            <div class="mr-auto">
                <a class="text-muted" href="{{ $article->author->url }}">{{ $article->author->name }}</a>
                <span class="d-none d-sm-inline">• {{ $article->date->isoFormat('ll') }} {{ $article->isPublished ? '' : '(не опубликована)'}}</span>
            </div>

            <livewire:articles.article-actions :article="$article"/>
        </div>
    </div>
</div>