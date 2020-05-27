@extends('layouts.page')

@section('content')
    <h1 class="text-center my-2">Расписание</h1>

    <div class="container">
        @admin
            <div class="mb-2 card shadow w-100">
                <div class="card-body py-2 row">
                    <a href="{{ route('schedule.create') }}" class="ml-2 font-weight-bolder">
                        <i class="fas fa-plus my-auto mr-1"></i>
                        Добавить мероприятие
                    </a>
                </div>
            </div>
        @endadmin

        @if($schedules->count() == 0)
            <div class="d-flex mt-5 justify-content-center text-center">
                <span class="h4 text-muted">Скоро здесь будут события, проходящие в клубе.📅</span>
            </div>
        @else
            @component('components.card-lists.schedules', ['schedules' => $schedules])@endcomponent
        @endif
    </div>
@endsection
