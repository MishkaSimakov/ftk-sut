@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow mt-2">
                    <div class="card-header">Редактировать событие</div>

                    <div class="card-body">
                        <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('schedule.update', compact('schedule')) }}">
                            @csrf
                            @method("PUT")

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">Название</label>

                                <div class="col-md-6">
                                    <input value="{{ old('title') ?? $schedule->title }}" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" required>

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
                                    <input value="{{ old('subtitle') ?? $schedule->subtitle }}" id="subtitle" type="text" class="form-control{{ $errors->has('subtitle') ? ' is-invalid' : '' }}" name="subtitle">

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
                                    <input id="date_start" type="datetime-local" value="{{ old('date_start') ?? $schedule->date_start->format('Y-m-d\TH:i') }}" class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}" name="date_start" required>

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
                                    <input id="date_end" type="datetime-local" value="{{ old('date_end') ?? $schedule->date_end->format('Y-m-d\TH:i') }}" class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }}" name="date_end" min="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>

                                    @if ($errors->has('date_end'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_end') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <travel-settings old_is_travel="{{ old('is_travel') ?? !!$schedule->travel }}" old_travel_type="{{ old('travel_type') ?? optional($schedule->travel)->is_bike ? 'bike' : 'hiking' }}" old_distance="{{ old('distance') ?? optional($schedule->travel)->distance }}"></travel-settings>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Сохранить
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
