@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Мероприятия')

@section('content')
    <h1 class="text-center mb-4">Создать мероприятие</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Название</label>
                    <input id="name" type="text"
                           maxlength="75"
                           class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autofocus
                    >

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <input id="description" type="text"
                           maxlength="200"
                           class="form-control @error('description') is-invalid @enderror" name="description"
                           value="{{ old('description') }}" autofocus
                    >

                    @error('description')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="date_start">Дата начала</label>
                        <input id="date_start" type="datetime-local"
                               class="form-control @error('date_start') is-invalid @enderror" name="date_start"
                               min="{{ now()->isoFormat('YYYY-MM-DD[T]HH:mm') }}"
                               value="{{ old('date_start') }}" required autofocus
                        >

                        @error('date_start')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md">
                        <label for="date_end">Дата конца</label>
                        <input id="date_end" type="datetime-local"
                               class="form-control @error('date_end') is-invalid @enderror" name="date_end"
                               min="{{ now()->isoFormat('YYYY-MM-DD[T]HH:mm') }}"
                               value="{{ old('date_end') }}" required autofocus
                        >

                        @error('date_end')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input id="image" type="file"
                           class="form-control-file @error('image') is-invalid @enderror" name="image"
                           accept="image/*" required autofocus
                    >

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
