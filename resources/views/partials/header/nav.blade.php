<nav class="main-navigation navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="logo navbar-brand" href="{{ route('main') }}">ФТК СЮТ </a>
    <div class="site-navigation__toggler navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Меню">
        <button class="site-navigation__toggler__button" type="button"></button>
    </div>
    <div class="site-navigation collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="page-navigation navbar-nav mr-auto">
            <li class="page-navigation__item nav-item"><a class="page-navigation__link nav-link" href="{{ route('rating.index') }}">Рейтинг</a></li>
            <li class="page-navigation__item nav-item"><a class="page-navigation__link nav-link" href="{{ route('achievements.index') }}">Достижения</a></li>
            <li class="page-navigation__item nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Статьи <span class="caret"></span>
                </a>

                <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-left">
                    <a href="{{ route('article.index', ['filter' => 'newest']) }}" class="page-navigation__link dropdown-item">
                        Новые
                    </a>

                    <a href="{{ route('article.index', ['filter' => 'best']) }}" class="page-navigation__link dropdown-item">
                        Популярные
                    </a>

                    @admin
                    <a href="{{ route('article.notPublished') }}" class="page-navigation__link dropdown-item">
                        Требуют проверки
                    </a>
                    @endadmin
                </div>
            </li>
            <li class="page-navigation__item nav-item"><a class="page-navigation__link nav-link" href="{{ route('schedule.index') }}">Расписание</a></li>

            @admin
                <li class="page-navigation__item nav-item"><a class="page-navigation__link nav-link" href="{{ route('admin.index') }}">Панель администратора</a></li>
            @endadmin
        </ul>
        <ul class="user-navigation navbar-nav">
            @guest
                <li class="user-navigation__item nav-item"><a class="user-navigation__link nav-link" href="{{ route('register') }}">Регистрация</a></li>
                <li class="user-navigation__item nav-item"><a class="user-navigation__link nav-link" href="{{ route('login') }}">Вход</a></li>
            @else
                <li class="user-navigation__item nav-item dropdown">
                    <a id="navbarDropdown" class="user-navigation__link nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Выйти
                        </a>

                        <a class="user-navigation__link dropdown-item" href="{{ route('home') }}">
                            Личный кабинет
                        </a>

                        <a class="user-navigation__link dropdown-item" href="{{ route('settings.show') }}">
                            Настройки аккаунта
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<script>
    const menuButton = document.querySelector('.site-navigation__toggler');

    menuButton.addEventListener('click', function () {
        menuButton.classList.toggle('site-navigation__toggler--close');
    });
</script>
