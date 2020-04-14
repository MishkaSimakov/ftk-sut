<div class="card shadow m-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4 class="d-block font-weight-bold text-primary">
            {{ $current_news->title }}
        </h4>

        <div>
            <h4 class="font-weight-light text-gray-500 mr-3">{{ $current_news->created_at->locale('ru')->isoFormat('D MMMM Y') }}</h4>
        </div>
    </div>

    <div class="card-body">
        <p>{!! $current_news->body !!}</p>
    </div>

    <div class="card-footer">
        <div class="h3 my-auto ml-0 d-inline-block">
            <a class="article__comment_link">
                <i class="far fa-eye"></i>
            </a>

            <span class="article__comments_counter">{{ views($current_news)->count() }}</span>
        </div>
    </div>
</div>
