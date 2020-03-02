@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Расписание</h1>

    @admin
        <h2 class="ml-2 mb-2"><a href="{{ route('schedule.create') }}"><i class="fas fa-plus mr-1"></i>Добавить событие</a></h2>
    @endadmin

    <div class="container">
        @if($schedules->count() == 0)
            <div class="d-flex mt-5 justify-content-center">
                <span class="h4 text-muted">Скоро здесь будут события, проходящие в клубе.📅</span>
            </div>
        @endif

        @component('components.card-lists.schedules', ['schedules' => $schedules])@endcomponent
    </div>

{{--    TODO: сделать отдельный view для архивных событий (все события) --}}
@endsection

@auth
    @if(Auth::user()->student)
        @push('script')
            <script type="text/javascript">
                function addStudent(schedule_id) {
                    $.ajax({
                        url: "{{ route('api.schedule.add_student') }}",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            student_id: '{{ Auth::user()->student->id }}',
                            schedule_id: schedule_id
                        },
                        success: function (data) {
                            $('#student_count_' + schedule_id).html(Number(data));
                        }
                    });
                }

                function removeStudent(schedule_id) {
                    {{--$.ajax({--}}
                    {{--    url: "{{ route('api.schedule.remove_student') }}",--}}
                    {{--    method: "POST",--}}
                    {{--    dataType: 'json',--}}
                    {{--    data: {--}}
                    {{--        student_id: '{{ Auth::user()->student->id }}',--}}
                    {{--        schedule_id: schedule_id--}}
                    {{--    },--}}
                    {{--    success: function (data) {--}}
                    {{--        $('#student_count_' + schedule_id).html(Number(data));--}}
                    {{--    }--}}
                    {{--});--}}
                }
            </script>
        @endpush
    @endif
@endauth
