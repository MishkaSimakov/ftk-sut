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

                <div class="card mt-3">
                    <div class="card-header">Получение регистрационного кода</div>

                    <div class="card-body">
                        <form id="form" method="POST" action="">
                            @csrf

                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">Имя пользователя</label>

                                <div class="col-md-7">
                                    <input oninput="get_code(this)" list="users" id="user" type="text" class="form-control" name="user" required>
                                </div>

                                <datalist id="users">
                                    @foreach($students as $student)
                                        <option>{{ $student->user->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">Регистрационный код</label>

                                <div class="col-md-7 py-2">
                                    <span id="register_code">...</span>
                                </div>

                                <datalist id="users">
                                    @foreach($students as $student)
                                        <option>{{ $student->user->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </form>
                    </div>
                </div>
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

        function get_code(input) {
            console.log($(input).val())

            $.ajax({
                url: "{{ route('api.admin.get_code') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    name: $(input).val(),
                },
                success: function (register_code) {
                    $('#register_code').html(register_code)
                }
            })
        }
    </script>
@endpush
