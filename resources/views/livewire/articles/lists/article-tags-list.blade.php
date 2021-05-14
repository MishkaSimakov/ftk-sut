<div class="card mt-3">
    <div class="card-body py-2">
        <div class="row">
            @foreach($tags as $tag)
                <a href="{{ $tag->url }}"
                   class="col-md-3 text-center border-right py-2 article-tag text-truncate"
                   title="{{ $tag->name }}"
                >
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>
