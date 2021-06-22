@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Расписание')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Редактировать мероприятие</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Название</label>
                    <input id="name" type="text"
                           maxlength="75"
                           class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') ?? $event->name }}" required autofocus
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
                           value="{{ old('description') ?? $event->description }}" autofocus
                    >

                    @error('description')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                @if($event->date_end->isFuture())
                    <div class="form-row">
                        @if($event->date_end->isFuture())
                            <div class="form-group col-md">
                                <label for="date_start">Дата начала</label>
                                <input id="date_start" type="datetime-local"
                                       class="form-control @error('date_start') is-invalid @enderror" name="date_start"
                                       min="{{ ($event->date_start->isFuture() ? now() : $event->date_start)->isoFormat('YYYY-MM-DD[T]HH:mm') }}"
                                       value="{{ old('date_start') ?? $event->date_start->isoFormat('YYYY-MM-DD[T]HH:mm') }}" required autofocus
                                >

                                @error('date_start')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group col-md">
                            <label for="date_end">Дата окончания</label>
                            <input id="date_end" type="datetime-local"
                                   class="form-control @error('date_end') is-invalid @enderror" name="date_end"
                                   min="{{ ($event->date_end->isFuture() ? now() : $event->date_end)->isoFormat('YYYY-MM-DD[T]HH:mm') }}"
                                   value="{{ old('date_end') ?? $event->date_end->isoFormat('YYYY-MM-DD[T]HH:mm') }}"
                                   required autofocus
                            >

                            @error('date_end')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input id="image" type="file" aria-describedby="imageHelp"
                           class="form-control-file @error('image') is-invalid @enderror" name="image"
                           accept="image/*" autofocus
                    >
                    <small id="imageHelp" class="form-text text-muted">Не загружайте ничего, если не хотите менять изображение.</small>

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>



                <div class="form-group form-check">
                    <input
                        type="checkbox" name="is_travel" class="form-check-input" id="is_travel" onclick="toggleTravelSettings()"
                        @if(old('is_travel') ? old('is_travel') === 'on' : $event->travel) checked @endif
                    >
                    <label class="form-check-label" for="is_travel">Это поход</label>
                </div>

                <div id="travelSettings" style="display: none;">
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="travel_type">Тип</label>
                            <select id="travel_type"
                                    class="custom-select @error('travel_type') is-invalid @enderror" name="travel_type"
                                    autofocus
                            >
                                @foreach(\App\Enums\TravelType::getInstances() as $type)
                                    <option
                                        value="{{ $type->value }}"
                                        @if ($type->value == (old('travel_type') ?? optional($event->travel)->type)) selected @endif
                                    >
                                        {{ $type->description }}
                                    </option>
                                @endforeach
                            </select>

                            @error('travel_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md">
                            <label for="travel_distance">Длина маршрута (км)</label>
                            <input id="travel_distance" type="number"
                                   step="0.1" min="0"
                                   class="form-control @error('travel_distance') is-invalid @enderror" name="travel_distance"
                                   value="{{ old('travel_distance') ?? optional($event->travel)->distance }}" autofocus
                            >

                            @error('travel_distance')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleTravelSettings() {
            let checkBox = document.getElementById("is_travel");
            let text = document.getElementById("travelSettings");

            if (checkBox.checked) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", toggleTravelSettings);
    </script>
@endpush
