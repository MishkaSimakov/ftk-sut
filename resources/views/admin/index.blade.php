@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Панель администратора</h1>

    <div class="container mt-3">
        <div class="alert alert-info alert-dismissible fade show" role="contentinfo">
            <strong>Внимание</strong> не используйте эту вкладку в личных интересах. За вами следит скрытая камера 📷
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @if (!$schedules->isEmpty())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Мероприятия</h6>
                </div>

                <div class="card-body">
                    @foreach($schedules as $schedule)
                        <ul class="" style="">
                            <li class="">
                                <h5 class="card-title spoiler_link text-primary" style="cursor: pointer" data-schedule="{{ $schedule->id }}">
                                    {{ $schedule->title }}

                                    <small>({{ $schedule->date_start->locale('ru')->isoFormat('Do MMMM HH:mm') }} - {{ $schedule->date_end->locale('ru')->isoFormat('Do MMMM HH:mm') }})</small>
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
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ученики</h6>
            </div>

            <div class="card-body">
                <form class="d-sm-block d-md-block d-lg-none d-xl-none" id="form" method="POST" action="">
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
                    </div>
                </form>

                <table id="students-table" class="table table-striped table-bordered" style="display: none; width:100%">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Регистрационный код</th>
                            <th>Администратор</th>
                            <th>День рождения</th>
                            <th>Ходит в клуб с</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td><a href="{{ $student->user->url }}" title="Страница пользователя">{{ $student->name }}</a></td>
                                <td>{{ $student->user->register_code }}</td>
                                <td>{{ $student->user->is_admin ? 'Да' : 'Нет' }}</td>
                                <td>{{ $student->birthday ? $student->birthday->format('d-m-Y') : 'Нет данных' }}</td>
                                <td>{{ $student->admissioned_at ? $student->admissioned_at->format('d-m-Y') : 'Нет данных' }}</td>
                                <td class="text-center" data-toggle="modal" data-target="#settings_student_{{ $student->id }}"><i style="cursor: pointer" class="text-primary fas fa-user-cog"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Имя</th>
                            <th>Регистрационный код</th>
                            <th>Администратор</th>
                            <th>День рождения</th>
                            <th>Ходит в клуб с</th>
                            <th>Управление</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Преподаватели</h6>
            </div>

            <div class="card-body">
                <table id="teachers-table" style="display: none" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Кружок</th>
                            <th>Регистрационный код</th>
                            <th>Изображение</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->last_name }}</td>
                                <td>{{ $teacher->first_name }}</td>
                                <td>{{ $teacher->middle_name }}</td>
                                <td>{{ $teacher->club->name }}</td>
                                <td>{{ $teacher->user->register_code }}</td>
                                <td><img alt="Изображение преподавателя" class="rounded" src="/image/{{ $teacher->getMedia()->first()->getUrl() }}" style="cursor: pointer; max-width: 5vw; max-height: 5vw;" data-lity data-lity-target="/image/{{ $teacher->getMedia()->first()->getUrl() }}"></td>
                                <td class="text-center" data-toggle="modal" data-target="#settings_teacher_{{ $teacher->id }}"><i style="cursor: pointer" class="text-primary fas fa-user-cog"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-primary" data-toggle="modal" data-target="#teacher_create_modal">Новый преподаватель<span class="ml-2 fa fa-plus"></span></button>
            </div>
        </div>
    </div>

    <div class="student_setting_modals">
        @foreach($students as $student)
            <!-- Modal -->
            <div class="modal fade" id="settings_student_{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="StudentSettings" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $student->user->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="settings_form_{{ $student->id }}" method="POST" action="{{ route('admin.student.settings', compact('student')) }}">
                                @csrf
                                @method("PUT")

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                                    <div class="col-md-6">
                                        <input value="{{ $student->user->name }}" id="name" type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label form-check-label text-md-right" for="is_admin">
                                        Администратор
                                    </label>

                                    <div class="col-md-6">
                                        <div class="form-check py-2 row">
                                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" {{ $student->user->is_admin ? 'checked' : '' }}>
                                            <span class="small text-danger">Осторожнее с этим!</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="birthday" class="col-md-4 col-form-label text-md-right">Дата рождения</label>

                                    <div class="col-md-6">
                                        <input id="birthday" type="date" value="{{ optional($student->birthday)->format('Y-m-d') }}" class="form-control" name="birthday">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="admissioned_at" class="col-md-4 col-form-label text-md-right">Дата поступления в клуб</label>

                                    <div class="col-md-6">
                                        <input id="admissioned_at" type="date" value="{{ optional($student->admissioned_at)->format('Y-m-d') }}" class="form-control" name="admissioned_at">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary" onclick="$('#settings_form_{{ $student->id }}').submit()">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="teacher_setting_modals">
    @foreach($teachers as $teacher)
        <!-- Modal -->
            <div class="modal fade" id="settings_teacher_{{ $teacher->id }}" tabindex="-1" role="dialog" aria-labelledby="TeacherSettings" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $teacher->fullName }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="teacher_settings_form_{{ $teacher->id }}" method="POST" action="{{ route('admin.teacher.settings', compact('teacher')) }}">
                                @csrf
                                @method("PUT")

                                <div class="form-group row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                                    <div class="col-md-6">
                                        <input value="{{ $teacher->last_name }}" id="last_name" type="text" class="form-control" name="last_name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>

                                    <div class="col-md-6">
                                        <input value="{{ $teacher->first_name }}" id="first_name" type="text" class="form-control" name="first_name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="middle_name" class="col-md-4 col-form-label text-md-right">Отчество</label>

                                    <div class="col-md-6">
                                        <input value="{{ $teacher->middle_name }}" id="middle_name" type="text" class="form-control" name="middle_name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="club_id" class="col-md-4 col-form-label text-md-right">Кружок</label>

                                    <div class="col-md-7">
                                        <select class="form-control" id="club_id" name="club_id" required>
                                            @foreach (\App\Club::all() as $club)
                                                <option value="{{ $club->id }}" {{ $teacher->club->id == $club->id ? 'selected' : '' }}>
                                                    {{ $club->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary" onclick="$('#teacher_settings_form_{{ $teacher->id }}').submit()">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="teacher_create_modal" tabindex="-1" role="dialog" aria-labelledby="TeacherSettings" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новый преподаватель</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="teacher_create_form" method="POST" action="{{ route('teacher.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">Отчество</label>

                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="form-control" name="middle_name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="club_id" class="col-md-4 col-form-label text-md-right">Кружок</label>

                            <div class="col-md-7">
                                <select class="form-control" id="club_id" name="club_id" required>
                                    @foreach (\App\Club::all() as $club)
                                        <option value="{{ $club->id }}">
                                            {{ $club->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">Фотография</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file" class="my-auto form-control-file" accept="image/*" name="avatar" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="$('#teacher_create_form').submit()">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#edit_avatar').each(function () {
               $(this).attr('filename', $(this).attr('data-value'));
            });

            $('.spoiler_link').each(function () {
                $(this).click(function () {
                    $('.spoiler_body_' + $(this).attr('data-schedule')).toggle('normal');
                });
            });

            if ($(window).width() > 992) {
                $('#teachers-table').show()

                $('#students-table').DataTable({
                    'language': {
                        "decimal": "",
                        "emptyTable": "Нет учеников",
                        "info": "Ученики с _START_ по _END_ из _TOTAL_",
                        "infoEmpty": "Нет учеников",
                        "infoFiltered": "",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Показать _MENU_ пользователей",
                        "loadingRecords": "Загрузка...",
                        "processing": "Загрузка...",
                        "search": "Поиск:",
                        "zeroRecords": "Нет таких данных",

                        "paginate": {
                            "first": "Первый",
                            "last": "Последний",
                            "next": "<i class=\"fas fa-arrow-right\"></i>",
                            "previous": "<i class=\"fas fa-arrow-left\"></i>"
                        },

                        "aria": {
                            "sortAscending": ": упорядочить по возрастанию",
                            "sortDescending": ": упорядочить по убыванию"
                        }
                    }
                });

                $('#students-table').show()
            }
        });

        function get_code(input) {
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
