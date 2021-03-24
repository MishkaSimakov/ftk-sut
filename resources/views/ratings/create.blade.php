@extends('layouts.app')


@section('title', 'Рейтинг')

@section('content')
    <h1 class="text-center">Новый рейтинг</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rating.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="rating">Рейтинг</label>
                    <input type="file" class="form-control-file" id="rating" name="rating" accept=".xls" required>
                </div>

                <div class="form-group">
                    <label for="date">Дата</label>
                    <input
                        type="month"
                        class="form-control"
                        name="date"
                        id="date"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
