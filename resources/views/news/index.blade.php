@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Новости')
@section('description', 'Все последние новости ФТК на одной странице с возможностью оповещения по электронной почте.')
@section('robots', 'index, follow, noarchive')

@section('content')
    <h1 class="text-center mb-4">Новости</h1>

    @foreach($news as $n)
        <div class="card mb-4 {{ $n->isPublished ? '' : 'text-secondary' }}">
            <div class="card-body pb-2">
                <p class="h4 card-title">{{ $n->title }}</p>
                <div class="card-text">{!! $n->body !!}</div>

                <div class="row no-gutters text-muted mt-2 align-items-center">
                    <div class="mr-auto">
                        {{ $n->date->isoFormat('ll') }}
                        {{ $n->isPublished ? '' : '(не опубликована)'}}
                    </div>

                    <div class="mr-sm-3" style="font-weight: 500;">
                        <i class="far fa-eye"></i> {{ $n->views_count }}
                    </div>

                    @canany(['update', 'delete'], $n)
                        <div class="dropdown">
                            <button class="d-inline btn rounded-pill text-muted" type="button"
                                    id="news-more-dropdown-button-{{ $n->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    aria-label="Дополнительно">
                                <i class="fas fa-ellipsis-h fa-sm"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="news-more-dropdown-button-{{ $n->id }}">
                                @can('update', $n)
                                    <a class="dropdown-item" href="{{ route('news.edit', $n) }}">Редактировать</a>
                                @endcan
                                @can('delete', $n)
                                    <a
                                        class="dropdown-item text-danger"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $n->id }}').submit();"
                                        href="#"
                                    >
                                        Удалить
                                    </a>
                                    <form method="POST" id="delete-form-{{ $n->id }}"
                                          action="{{ route('news.destroy', $n) }}">
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
    @endforeach

    <div class="row no-gutters">
        <div class="mx-auto">
            {{ $news->links() }}
        </div>
    </div>
@endsection
