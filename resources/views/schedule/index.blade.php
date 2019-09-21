@include('partials.header')

<h1 class="text-center m-2">В клубе на этой неделе</h1>

@auth
  @if (Auth::user()->isAdmin)
    <h2 class="ml-2"><a href="{{ route('schedule.create') }}"><i class="fas fa-plus mr-1"></i>Добавить событие</a></h2>
  @endif
@endauth

<!-- <div class="container">
	<table class="table">
		<tbody>
			@foreach($lastSchedules as $schedule)
				<tr class="my-0">
					<th scope="row" class="text-center my-5">
						<p class="mb-0" style="text-align: center;">
							{{ $schedule->date_start->day }}
							{{ getRussianMonth($schedule->date_start, true) }}
						</p>

						<p>{{ getRussianWeekday($schedule->date_start) }}</p>
					</th>

					<th scope="row" class="text-center">
						<p>
							{{ $schedule->date_start->format('H:i') }} - 
							{{ $schedule->date_end->format('H:i') }}
						</p>
					</th>
						
					<th scope="row" class="text-center">
						<p>{{ $schedule->title }}</p>
					</th>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>-->

  @foreach($lastSchedules as $schedule)
    <div class="card m-3 d-inline-block" style="width: 18rem">
        <div class="card-body">
	        <h5 class="card-title">{{ $schedule->title }}</h5>
	        <p class="card-text">
            {{ $schedule->date_start->day }} {{ getRussianMonth($schedule->date_start, true) }} {{ $schedule->date_start->format('H:i') }} - {{ $schedule->date_end->format('H:i') }}
          </p>

	        @auth
		        <a href="#" onclick="event.preventDefault(); addPeople({{ $schedule->id }})" class="btn btn-primary">
					Я пойду <span id="people_count_{{ $schedule->id }}" class="badge badge-light ml-2">{{ $schedule->people_count }}</span>
				</a>
			@endauth
        </div>
    </div>
  @endforeach

  @if (!$oldSchedules->isEmpty())
    <h2 class="m-2 text-center">Архив</h2>
  @endif

  @foreach($oldSchedules as $schedule)
    <div class="card m-3 d-inline-block" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">{{ $schedule->title }}</h5>
          <p class="card-text">{{ $schedule->date_start }}</p>
        </div>
    </div>
  @endforeach

  @auth
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
  @endauth
@include('partials.footer')