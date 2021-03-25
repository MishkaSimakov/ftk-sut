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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.index') }}">Новости</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('article.index') }}">Статьи</a>

                        <div class="hover-dropdown-menu dropdown-menu">
                            <a class="dropdown-item" href="{{ route('article.create') }}">
                                Написать
                            </a>
                            <a class="dropdown-item" href="#">
                                Требуют проверки
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Расписание</a>
                    </li>
                    <li class="nav-item {{ (auth()->user() and auth()->user()->is_admin) ? 'dropdown' : '' }}">
                        <a class="nav-link" href="{{ route('rating.index') }}">Рейтинг</a>

                        @admin
                            <div class="hover-dropdown-menu dropdown-menu">
                                <a class="dropdown-item" href="{{ route('rating.create') }}">
                                    Загрузить
                                </a>
                            </div>
                        @endadmin
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
                            Симаков Михаил
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}">
                                Профиль
                            </a>
                            {{--  TODO: добавить сюда правильные ссылки--}}
                            <a class="dropdown-item" href="#">
                                Настройки
                            </a>
                            <a class="dropdown-item" href="#">
                                Оповещения
                            </a>
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
