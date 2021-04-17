<div class="card mb-3 {{ $news->isPublished ? '' : 'text-secondary' }}">
    <div class="card-body pb-2">
        <h5 class="card-title">{{ $news->title }}</h5>
        <div class="card-text">{!! $news->body !!}</div>

        <div class="row no-gutters text-muted mt-1">
            <div class="card-text align-self-center">
                {{ $news->date->isoFormat('ll') }}
                {{ $news->isPublished ? '' : '(не опубликована)'}}
            </div>

            <div class="ml-auto row no-gutters">
                <span class="align-self-center mr-sm-2" style="font-weight: 500;">
                    <i class="far fa-eye"></i> {{ $news->views }}
                </span>

                <div class="dropdown">
                    <button class="d-inline btn rounded-pill text-muted" type="button"
                            id="news-more-dropdown-button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h fa-sm"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="news-more-dropdown-button">
                        <a class="dropdown-item" href="{{ route('news.edit', $news) }}">Редактировать</a>
                        <a class="dropdown-item text-danger" href="#" wire:click.prevent="deleteNews">
                            Удалить
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
