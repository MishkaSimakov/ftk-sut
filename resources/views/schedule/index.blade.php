@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Расписание</h1>

    @admin
        <h2 class="ml-2 mb-2"><a href="{{ route('schedule.create') }}"><i class="fas fa-plus mr-1"></i>Добавить событие</a></h2>
    @endadmin

    <div class="container">
        @if($schedules->count() == 0)
            <div class="d-flex mt-5 justify-content-center text-center">
                <span class="h4 text-muted">Скоро здесь будут события, проходящие в клубе.📅</span>
            </div>
        @endif

        @component('components.card-lists.schedules', ['schedules' => $schedules])@endcomponent

        <h2 class="text-center"><a href="{{ route('schedule.archive') }}">Архив</a></h2>
    </div>
@endsection

@auth
    @push('script')
        <script type="text/javascript">
            function register(schedule_id) {
                $('#register_' + schedule_id).removeClass('schedule__unregistered').addClass('schedule__registered');

                $.ajax({
                    url: "{{ route('api.schedule.register') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        schedule_id: schedule_id
                    },
                    success: function (data) {
                        if (data === 'error') {
                            alert('😖О нет! Что-то не так!😖');
                            window.location.reload();
                        }
                    }
                });
            }

            function unregister(schedule_id) {
                $('#register_' + schedule_id).removeClass('schedule__registered').addClass('schedule__unregistered');

                $.ajax({
                    url: "{{ route('api.schedule.unregister') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        schedule_id: schedule_id
                    },
                    success: function (data) {
                        if (data === 'error') {
                            alert('😖О нет! Что-то не так!😖');
                            window.location.reload();
                        }
                    }
                });
            }
        </script>
    @endpush
@endauth
