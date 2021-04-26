<div class="card mb-3 {{ $news->isPublished ? '' : 'text-secondary' }}">
    <div class="card-body pb-2">
        <p class="h5 card-title">{{ $news->title }}</p>
        <div class="card-text">{!! $news->body !!}</div>

        <div class="row no-gutters text-muted mt-1 align-items-center">
            <div class="mr-auto">
                {{ $news->date->isoFormat('ll') }}
                {{ $news->isPublished ? '' : '(не опубликована)'}}
            </div>

            <div class="mr-sm-2" style="font-weight: 500;">
                <i class="far fa-eye"></i> {{ $news->views }}
            </div>

            @canany(['update', 'delete'], $news)
                <div class="dropdown">
                    <button class="d-inline btn rounded-pill text-muted" type="button"
                            id="news-more-dropdown-button-{{ $news->id }}"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Дополнительно">
                        <i class="fas fa-ellipsis-h fa-sm"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="news-more-dropdown-button-{{ $news->id }}">
                        @can('update', $news)
                            <a class="dropdown-item" href="{{ route('news.edit', $news) }}">Редактировать</a>
                        @endcan
                        @can('delete', $news)
                            <a
                                class="dropdown-item text-danger"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $news->id }}').submit();"
                                href="#"
                            >
                                Удалить
                            </a>
                            <form method="POST" id="delete-form-{{ $news->id }}"
                                  action="{{ route('news.destroy', $news) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endcan
                    </div>
                </div>
            @endcanany
        </div>
    </div>
</div>
