<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('main') }}">{{ config('app.name') }}</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-lg-auto mx-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('news.index') }}">Новости</a>

                        @can('create', \App\Models\News::class)
                            <div class="hover-dropdown-menu dropdown-menu">
                                <a class="dropdown-item" href="{{ route('news.create') }}">
                                    Написать
                                </a>
                            </div>
                        @endcan
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('articles.index') }}">Статьи</a>

                        @canany(['create', 'viewDrafts', 'viewUnpublished', 'viewUnchecked'], \App\Models\Article::class)
                            <div class="hover-dropdown-menu dropdown-menu">
                                @can('create', \App\Models\Article::class)
                                    <a class="dropdown-item" href="{{ route('articles.create') }}">
                                        Написать
                                    </a>
                                @endcan
                                @can('viewDrafts', \App\Models\Article::class)
                                    <a class="dropdown-item" href="{{ route('articles.drafts') }}">
                                        Черновики
                                    </a>
                                @endcan
                                @can('viewUnpublished', \App\Models\Article::class)
                                    <a class="dropdown-item" href="{{ route('articles.unpublished') }}">
                                        Отложенные
                                    </a>
                                @endcan
                                @can('viewUnchecked', \App\Models\Article::class)
                                    <a class="dropdown-item" href="{{ route('articles.unchecked') }}">
                                        Требуют проверки
                                    </a>
                                @endcan
                            </div>
                        @endcanany
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('events.index') }}">Расписание</a>

                        <div class="hover-dropdown-menu dropdown-menu">
                            <a class="dropdown-item" href="{{ route('events.past') }}">
                                Прошедшие
                            </a>
                            @can('create', \App\Models\Event::class)
                                <a class="dropdown-item" href="{{ route('events.create') }}">
                                    Создать
                                </a>
                            @endcan
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('rating.index') }}">Рейтинг</a>

                        @canany(['create', 'delete'], \App\Models\RatingPoint::class)
                            <div class="hover-dropdown-menu dropdown-menu">
                                @can('create', \App\Models\RatingPoint::class)
                                    <a class="dropdown-item" href="{{ route('rating.create') }}">
                                        Загрузить
                                    </a>
                                @endcan
                                @can('delete', \App\Models\RatingPoint::class)
                                    <a class="dropdown-item" href="{{ route('rating.destroyPage') }}">
                                        Удалить
                                    </a>
                                @endcan
                            </div>
                        @endcanany
                    </li>
                </ul>

                @guest
                    <a href="{{ route('login') }}" class="btn-outline-light btn mt-3 mt-lg-0">
                        Войти
                    </a>
                @else
                    <div class="dropdown">
                        <a class="text-white text-decoration-none" href="#" id="accountDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}">
                                Профиль
                            </a>
                            <a class="dropdown-item" href="{{ route('settings') }}">
                                Настройки
                            </a>

                            @admin
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Управление
                            </a>
                            @endadmin

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item text-danger" href=""
                               onclick="event.preventDefault(); $('#logout-form').submit();">
                                Выйти
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>
