<div>
    @foreach($articles as $article)
        <livewire:articles.article-single :article="$article" :key="$article->id" />
    @endforeach
</div>
