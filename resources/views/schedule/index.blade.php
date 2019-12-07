@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">В клубе на этой неделе</h1>

    @admin
        <h2 class="ml-2"><a href="{{ route('schedule.create') }}"><i class="fas fa-plus mr-1"></i>Добавить событие</a></h2>
    @endadmin

    <div class="container">
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
    @push('script')
        <script type="text/javascript">
            function addPeople(schedule_id) {
                $.ajax({
                    url: "{{ route('api.schedule.add_people') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        schedule_id: schedule_id
                    },
                    success: function (data) {
                        $('#people_count_' + schedule_id).html(Number(data));
                    }
                });
            }
        </script>
    @endpush
@endauth
