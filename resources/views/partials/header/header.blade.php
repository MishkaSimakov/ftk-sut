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
                    <li class="nav-item">
                        <a class="nav-link" href="#">Статьи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Расписание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ratings.index') }}">Рейтинг</a>
                    </li>
                </ul>


                {{--            account buttons --}}
                @guest
                    <a href="{{ route('login') }}" class="btn-outline-light btn mt-3 mt-lg-0">
                        Войти
                    </a>
                @else
                    Вы вошли!
                @endguest
            </div>
        </div>
    </nav>
</header>
