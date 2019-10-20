@include('partials.header')

<h1 class="text-center m-2">Панель администратора</h1>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Получение ссылки для регистрации</div>

				<div class="card-body">
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">Фамилия и имя</label>

						<div class="col-md-6">
							<input id="name" type="text" class="form-control" name="name" required>
						</div>
					</div>

					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							<button class="btn btn-primary" id="load_button">
								Загрузить
							</button>

							<span class="ml-3" href="" id="register_link"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if (!$schedules->isEmpty())
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Просмотр людей</div>

                    <div class="card-body">
                        @foreach($schedules as $schedule)
                            <ul class="" style="">
                                <li class="">
                                    <h5 class="card-title spoiler_link text-primary" style="cursor: pointer" data-schedule="{{ $schedule->id }}">
                                        {{ $schedule->title }}

                                        <small>({{ $schedule->date_start->day }} {{ getRussianMonth($schedule->date_start, true) }} {{ $schedule->date_start->format('H:i') }} - {{ $schedule->date_end->format('H:i') }})</small>
                                    </h5>

                                    <ol class="spoiler_body_{{ $schedule->id }}" style="display: none">
                                        @foreach($schedule->users as $user)
                                            <li>
                                                <p class="ml-2"><a href="{{ $user->url }}">{{ $user->name }}</a></p>
                                            </li>
                                        @endforeach
                                    </ol>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
	$(document).ready(function () {
        $('.spoiler_link').each(function () {
            $(this).click(function () {
                if ($('.spoiler_body_' + $(this).attr('data-schedule')).css('display') == 'none') {
                    $('.spoiler_body_' + $(this).attr('data-schedule')).show('normal');
                } else {
                    $('.spoiler_body_' + $(this).attr('data-schedule')).hide('normal');
                }
            });
        });

		$("#load_button").click(function() {
			$.ajax({
				url: "{{ route('api.admin.register_link') }}",
				method: "POST",
				dataType: 'json',
				data: {
					name: $('#name').val(),
				},
				success: function (data) {
					console.log(data);

					$('#register_link').html('<a href="' + data + '">ссылка</a> скопирована!');
					navigator.clipboard.writeText(data);
				}
			});
		});
	});
</script>

@include('partials.footer')
