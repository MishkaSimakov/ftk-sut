@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">В клубе на этой неделе</h1>

    @admin
        <h2 class="ml-2"><a href="{{ route('schedule.create') }}"><i class="fas fa-plus mr-1"></i>Добавить событие</a></h2>
    @endadmin

    <div class="container">
{{--        TODO: сделать оформление (чтобы кнопка пойти была всегда внизу, и в строке было по 4 блока) --}}
        @component('components.card-lists.schedules', ['schedules' => $lastSchedules])@endcomponent
    </div>

    @if (!$oldSchedules->isEmpty())
        <h2 class="m-2 text-center">Архив</h2>
    @endif

    <div class="container">
        @component('components.card-lists.schedules', ['schedules' => $oldSchedules])@endcomponent
    </div>
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
            </script>
        @endpush
    @endif
@endauth
