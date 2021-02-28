<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('main') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse container" id="navbarNav">
                <ul class="navbar-nav mx-auto">
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
            </div>

            {{--            account buttons --}}
            <a href="#" class="btn-outline-light btn">
                Войти
            </a>
        </div>
    </nav>
</header>
