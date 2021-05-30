@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Настройки аккаунта')

@section('content')
    <h1 class="text-center mb-4">Настройки аккаунта</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <p class="card-title h6">Общая информация</p>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') ?? $user->email }}"
                    >

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <p class="card-title h6 mt-5">Уведомления</p>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeNews" name="noticeNews"
                           @if($user->notification_subscriptions->hasFlag(\App\Enums\UserNotificationSubscriptions::NewsNotifications()))
                           checked
                        @endif
                    >
                    <label class="form-check-label" for="noticeNews">Уведомлять по email о новостях</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeArticles" name="noticeArticles"
                           @if($user->notification_subscriptions->hasFlag(\App\Enums\UserNotificationSubscriptions::ArticleNotifications()))
                           checked
                        @endif
                    >
                    <label class="form-check-label" for="noticeArticles">Уведомлять по email о статьях</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeEvents" name="noticeEvents"
                           @if($user->notification_subscriptions->hasFlag(\App\Enums\UserNotificationSubscriptions::EventNotifications()))
                           checked
                        @endif
                    >
                    <label class="form-check-label" for="noticeEvents">Уведомлять по email о мероприятиях</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeRating" name="noticeRating"
                           @if($user->notification_subscriptions->hasFlag(\App\Enums\UserNotificationSubscriptions::RatingNotifications()))
                           checked
                        @endif
                    >
                    <label class="form-check-label" for="noticeRating">Уведомлять по email о новом рейтинге</label>
                </div>

                <button type="submit" class="btn btn-primary mr-2 mt-3">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
