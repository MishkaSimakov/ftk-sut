@extends('layouts.page')

@section('content')

<h1 class="text-center m-2"></h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header">Создать событие</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('schedule.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Описание</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_start" class="col-md-4 col-form-label text-md-right">Дата начала</label>

                            <div class="col-md-6">
                                <input id="date_start" type="datetime-local" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" class="form-control" name="date_start" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_end" class="col-md-4 col-form-label text-md-right">Дата окончания</label>

                            <div class="col-md-6">
                                <input id="date_end" type="datetime-local" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" class="form-control" name="date_end" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Создать
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
