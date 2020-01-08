@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Панель администратора</h1>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (!$schedules->isEmpty())
                    <div class="card">
                        <div class="card-header">Просмотр людей</div>

                        <div class="card-body">
                            @foreach($schedules as $schedule)
                                <ul class="" style="">
                                    <li class="">
                                        <h5 class="card-title spoiler_link text-primary" style="cursor: pointer" data-schedule="{{ $schedule->id }}">
                                            {{ $schedule->title }}

                                            <small>({{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }} - {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }})</small>
                                        </h5>

                                        <ol class="spoiler_body_{{ $schedule->id }}" style="display: none">
                                            @foreach($schedule->students as $student)
                                                <li>
                                                    <p class="ml-2"><a href="{{ optional($student->user)->url }}">{{ $student->name }}</a></p>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.spoiler_link').each(function () {
                $(this).click(function () {
                    $('.spoiler_body_' + $(this).attr('data-schedule')).toggle('normal');
                });
            });


        });
    </script>
@endpush
