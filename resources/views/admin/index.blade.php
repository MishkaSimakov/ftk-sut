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

<div class="container mt-3">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Рейтинг преподователей (только для Паши!!!)</div>

				<div class="card-body">
					@foreach($teachers as $teacher)
						<div class="form-group row">
							<a href="#" onclick="event.preventDefault();" data-teacher="{{ $teacher->id }}" class="add_achievement_link text-md-right">{{ $teacher->name }}</a>
						</div>

						<div class="modal bd-example-modal-lg fade" id="modal_{{ $teacher->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Добавление достижений для {{ $teacher->name }}</h4>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
										<div class="container px-5">
											@foreach($teacher->notGettedAchievements as $achievement)
												<div class="{{ $teacher->id }}_achievement_{{ $achievement->id }} card m-3 d-inline-block" style="width: 18rem">

													<img class="card-img-top" src="{{ $achievement->image_url }}" alt="Изображение от достижения">

													<div class="card-body">
														<h5 class="card-title">
															{{ $achievement->title }}
														</h5>
														<p class="card-text">
															{{ $achievement->body }}
														</p>

														<a href="#" onclick="event.preventDefault(); addAchievement({{ $achievement->id }}, {{ $teacher->id }})" class="btn btn-primary">
															Добавить

															<span class="badge badge-light ml-2">
																{{ $achievement->points }}
															</span>
														</a>
													</div>
												</div>
										  	@endforeach
									  	</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

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
                                    @foreach($schedule->user_schedules as $user_schedule)
                                        <li>
                                            <p class="ml-2"><a href="{{ $user_schedule->user->url }}">{{ $user_schedule->user->name }}</a></p>
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

		$('.add_achievement_link').each(function() {
			$(this).click(function() {
				$('#modal_' + $(this).attr('data-teacher')).modal('show');
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

	function addAchievement(achievement_id, teacher_id) {
		$.ajax({
			url: "{{ route('api.admin.add_achievement') }}",
			method: "POST",
			dataType: 'json',
			data: {
				teacher_id: teacher_id,
				achievement_id: achievement_id,
			}
		});

		$('.' + teacher_id + '_achievement_' + achievement_id).remove();
	}
</script>

@include('partials.footer')
