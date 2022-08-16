@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Главная страница')
@section('description', 'Сайт Фототехнического клуба СЮТ. Здесь есть всё, чтобы быть активным кружковцем и не сачковать! Новости, расписание, статьи, рейтинг - и всё это на одном сайте.')
@section('robots', 'index, follow')

@section('masthead')
    <header class="masthead">
        <div class="container">
            <div class="text-left">
                <h1 class="display-3" style="max-width: 75%">
                    Фототехнический клуб СЮТ
                </h1>

                <p class="lead">
                    Клуб для самых активных и любознательных детей Волгодонска
                </p>
            </div>

            <div class="row no-gutters mt-5 w-100">
                <div>
                    <a class="btn btn-primary btn-lg" href="{{ route('about') }}">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-md-right border-bottom border-md-bottom-0 d-flex flex-column text-center">
                    <span class="h2 font-weight-bolder">{{ $statistics['users_count'] }}</span>
                    <span class="h4 font-weight-normal">Пользователей</span>
                </div>

                <div class="col-md-4 border-md-right border-bottom border-md-bottom-0 d-flex flex-column text-center">
                    <span class="h2 font-weight-bolder">{{ $statistics['articles_count'] }}</span>
                    <span class="h4 font-weight-normal">Статей</span>
                </div>

                <div class="col-md-4 d-flex flex-column text-center">
                    <span class="h2 font-weight-bolder">{{ $statistics['events_count'] }}</span>
                    <span class="h4 font-weight-normal">Мероприятий</span>
                </div>
            </div>
        </div>
    </div>

    <section style="margin-top: 6rem;">
        <div class="row">
            <div class="col-md-6 d-flex flex-column">
                <h2 class="display-4">Новости</h2>

                <p class="lead">Все последние новости ФТК на одной странице с возможностью оповещения
                    по электронной почте.</p>

                <div class="mt-auto">
                    <a href="{{ route('news.index') }}" class="btn btn-primary">
                        Подробнее
                    </a>
                </div>
            </div>

            <div class="col-md-6 d-none d-md-block">
                <img alt="Новости" class="img-fluid rounded" src="{{ asset('storage/pages/welcome/news.png') }}">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 d-none d-md-block">
                <img alt="Статьи" class="img-fluid rounded" src="{{ asset('storage/pages/welcome/articles.png') }}">
            </div>

            <div class="col-md-6 d-flex flex-column">
                <h2 class="display-4">Статьи</h2>

                <p class="lead">Более 100 статей от учеников и преподавателей ФТК всего в одном клике от вас.</p>

                <div class="mt-auto">
                    <a href="{{ route('articles.index') }}" class="btn btn-primary">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 d-flex flex-column">
                <h2 class="display-4">Расписание</h2>

                <p class="lead">Ближайшие мероприятия ФТК со списком участников и подробной
                    информацией, специально для вас.</p>

                <div class="mt-auto">
                    <a href="{{ route('events.index') }}" class="btn btn-primary">
                        Подробнее
                    </a>
                </div>
            </div>

            <div class="col-md-6 d-none d-md-block">
                <img alt="Расписание" class="img-fluid rounded" src="{{ asset('storage/pages/welcome/events.png') }}">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 d-none d-md-block">
                <img alt="Рейтинг" class="img-fluid rounded" src="{{ asset('storage/pages/welcome/rating.png') }}">
            </div>

            <div class="col-md-6 d-flex flex-column">
                <h2 class="display-4">Рейтинг</h2>

                <p class="lead">Возможность сравнить себя с сотнями других учеников по различным параметрам за выбранный
                    промежуток времени.</p>

                <div class="mt-auto">
                    <a href="{{ route('rating.index') }}" class="btn btn-primary">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center w-100 mt-5 text-muted">
            И ещё много всего интересного...
        </div>
    </section>

    <section style="margin-top: 6rem;">
        <h2 class="display-4 text-center">Хотите что-то предложить?</h2>

        <div class="row justify-content-center mt-3">
            <form class="col-md-8" method="POST" action="{{ route('reviews.store') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="body">Ваши идеи и предложения</label>
                    <textarea
                        class="form-control" id="body" name="body" rows="10"
                        placeholder="Опишите как можно подробнее, что вы хотели бы изменить или добавить"
                        required
                    >
                </textarea>
                </div>

                <div class="form-group row">
                    <div class="col-md-6"> {!! htmlFormSnippet() !!} </div>
                </div>

                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    {!! htmlScriptTagJsApi() !!}
@endpush
