<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>ФТК СЮТ</title>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  {{-- Icons --}}
  <script src="https://kit.fontawesome.com/799166843b.js" crossorigin="anonymous"></script>

{{--  text editor  --}}
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

{{--  lity for lightboxes  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
  <nav class="header-nav navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        ФТК CЮТ
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
                <a id="navbar" class="nav-link" href="{{ route('rating.index') }}" role="button">
                    Рейтинг
                </a>
            </li>
            <li class="nav-item">
                <a id="navbar" class="nav-link" href="{{ route('achievements.index') }}" role="button">
                    Достижения
                </a>
            </li>
            <li class="nav-item">
                <a id="navbar" class="nav-link" href="{{ route('article.index') }}" role="button">
                    Статьи
                </a>
            </li>
            <li class="nav-item">
                <a id="navbar" class="nav-link" href="{{ route('schedule.index') }}" role="button">
                    Расписание
                </a>
            </li>

            @admin
                <li class="nav-item">
                    <a title="Разделяй и властвуй" id="navbar" class="nav-link" href="{{ route('admin.index') }}" role="button">
                        Панель администратора
                    </a>
                </li>
            @endadmin
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Вход</a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
            </li>
          @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  Выйти
                </a>

                <a class="dropdown-item" href="{{ route('home') }}">
                  Личный кабинет
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
            @endguest
        </ul>
      </div>
    </div>
  </nav>

  <main class="main mb-2">
