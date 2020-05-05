@extends('layouts.page')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="card">
                    <user-photo src="{{ $user->getMedia()->count() ? $user->getMedia()->first()->getUrl() : 'https://upload.wikimedia.org/wikipedia/commons/4/46/%D0%A1%D0%B5%D1%80%D1%8B%D0%B9_%D1%86%D0%B2%D0%B5%D1%82-_2014-03-15_18-16.jpg' }}" editable="true"></user-photo>

                    <div class="card-body">
                        <h4 class="card-title text-center">{{ $user->name }}</h4>

                        <a href="{{ route('settings.show') }}">
                            <button class="btn btn-outline-primary w-100">
                                Настройки аккаунта
                            </button>
                        </a>

                        <hr>
                        <div class="card-text">
                            @if ($user->description)
                                {!! $user->description !!}
                            @else
                                <p>Здесь ничего нет! Но вы можете <a href="{{ route('settings.show') }}" class="text-info">написать что-нибудь о себе</a></p>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        @if ($user->vk_link)
                            <a class="h3" href="{{ $user->vk_link }}"><i class="fab fa-vk"></i></a>
                        @endif
                        @if ($user->phone)
                            <a class="ml-2 h3" href="tel:{{ $user->phone }}"><i class="fas fa-phone"></i></a>
                        @endif
                        @if (!$user->phone and !$user->vk_link)
                            <a href="{{ route('settings.show') }}" class="text-info">Добавить контакты</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="btn-toolbar mb-3" role="toolbar">
                    <div class="w-100 btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary">Статьи</button>
                    </div>
                </div>

                <div id="tabs">
                    <div id="articles">
                        @component('components.card-lists.articles', ['articles' => $articles])@endcomponent

                        <div class="d-flex">
                            <div class="mx-auto">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
