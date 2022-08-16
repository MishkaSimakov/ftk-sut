@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Расписание')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Импортировать походы</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="rating">Походы</label>
                    <input type="file" class="form-control-file" id="travels" name="travels" accept=".xls" required>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
