@extends('layouts.page')

@section('content')

<h1 class="text-center m-2"></h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mt-2">
                <div class="card-header">Создать событие</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('schedule.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Название</label>

                            <div class="col-md-6">
                                <input value="{{ old('title') }}" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subtitle" class="col-md-4 col-form-label text-md-right">Дополнительно</label>

                            <div class="col-md-6">
                                <input value="{{ old('subtitle') }}" id="subtitle" type="text" class="form-control{{ $errors->has('subtitle') ? ' is-invalid' : '' }}" name="subtitle">

                                @if ($errors->has('subtitle'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subtitle') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_start" class="col-md-4 col-form-label text-md-right">Дата начала</label>

                            <div class="col-md-6">
                                <input id="date_start" type="datetime-local" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}" name="date_start" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" required>

                                @if ($errors->has('date_start'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_start') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_end" class="col-md-4 col-form-label text-md-right">Дата окончания</label>

                            <div class="col-md-6">
                                <input id="date_end" type="datetime-local" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }}" name="date_end" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}T{{ Carbon\Carbon::now()->format('H:i') }}" required>

                                @if ($errors->has('date_end'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_end') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Изображение</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control-file" accept="image/*" name="file" required>
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
