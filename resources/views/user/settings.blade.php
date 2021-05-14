@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center mb-4">Настройки аккаунта</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('article.store') }}" method="POST">
                @csrf

                <p class="card-title h6">Общая информация</p>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') ?? auth()->user()->email }}"
                    >

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <p class="card-title h6 mt-5">Уведомления</p>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeNews">
                    <label class="form-check-label" for="noticeNews">Уведомлять по email о новостях</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeEvents">
                    <label class="form-check-label" for="noticeEvents">Уведомлять по email о мероприятиях</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="noticeRating">
                    <label class="form-check-label" for="noticeRating">Уведомлять по email о новом рейтинге</label>
                </div>
            </form>
        </div>
    </div>
@endsection
