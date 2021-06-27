@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Настройки аккаунта')
@section('description', '')
@section('robots', 'noindex, follow')

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

                @admin
                    <div class="form-group">
                        <label for="name">Фамилия, Имя (отчество)</label>
                        <input id="name" type="text"
                               maxlength="75"
                               class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ old('name') ?? $user->name }}" required autofocus
                        >

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Тип</label>
                        <select id="type"
                                class="custom-select @error('type') is-invalid @enderror" name="type"
                                required autofocus
                        >
                            @foreach(\App\Enums\UserType::getInstances() as $type)
                                <option
                                    value="{{ $type->value }}"
                                    @if ($type->value == (old('type') ?? $user->type->value)) selected @endif
                                >
                                    {{ $type->description }}
                                </option>
                            @endforeach
                        </select>

                        @error('type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group form-check">
                        <input
                            type="checkbox" name="is_admin" class="form-check-input" id="is_admin"
                            @if(old('is_admin') ?? $user->is_admin) checked @endif
                        >
                        <label class="form-check-label" for="is_admin">Администратор</label>
                    </div>
                @endadmin

                <button type="submit" class="btn btn-primary mr-2 mt-3">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
