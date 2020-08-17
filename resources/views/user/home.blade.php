@extends('layouts.page')

@section('content')
    <div id="info" class="my-2 card shadow w-100">
        <div class="container-fluid">
            <div class="row">
                <user-photo class="col-md-6 p-0" src="{{ $user->imageUrl }}" editable="true"></user-photo>

                <div class="d-flex flex-column col-md-6 py-2 px-3">
                    <div class="card-title">
                        <h2 class="text-center font-weight-bold">
                            {{ $user->name }}
                        </h2>
                    </div>

                    @if ($user->description)
                        <p class="card-text">{!! $user->description !!}</p>
                    @else
                        <a href="{{ route('settings.show') }}">Расскажите людям о себе!</a>
                    @endif

                    <div class="mt-auto">
                        @if ($user->vk_link)
                            <a class="h3" href="{{ $user->vk_link }}"><i class="fab fa-vk"></i></a>
                        @endif
                        @if ($user->phone)
                            <a class="ml-2 h3" href="tel:{{ $user->phone }}"><i class="fas fa-phone"></i></a>
                        @endif
                        @if (!$user->phone and !$user->vk_link)
                            <a href="{{ route('settings.show') }}">Добавьте контакты</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($achievements)
        <div id="achievements" class="mt-4">
            <h3 class="mb-2 text-muted">Достижения</h3>

            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
        </div>
    @endif

    @if ($user->student)
        <div id="stat" class="mt-4">
            <h3 class="mb-2 text-muted">Статистика</h3>

            <stat user="{{ $user->id }}"></stat>
        </div>
    @endif

    <h3 class="mt-4 text-muted">Статьи</h3>

    <div id="articles">
        <articles-list show_search="false" url="{{ route('api.user.articles', compact('user')) }}"></articles-list>
    </div>
@endsection

@push('side')
    <div class="card mt-2">
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li><a href="#info"><i class="fas fa-user mr-2"></i>Информация</a></li>

                @if ($achievements)
                    <li><a href="#achievements"><i class="fas fa-star mr-2"></i>Достижения</a></li>
                @endif
                @if ($user->student)
                    <li><a href="#stat"><i class="fas fa-align-left mr-2"></i>Статистика</a></li>
                @endif

                @if ($user->articles->count())
                    <li><a href="#articles"><i class="fas fa-pen mr-2"></i>Статьи</a></li>
                @endif
            </ul>
        </div>
    </div>
@endpush
