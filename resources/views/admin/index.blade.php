@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Панель администратора</h1>

    <div class="container mt-3">
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Пользователи</h6>
            </div>

            <div class="card-body">
                <form class="d-sm-block d-md-none d-lg-none d-xl-none" id="form" method="POST" action="">
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

                <table id="admin-table" class="table table-striped table-bordered" style="display: none; width:100%">
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
    </div>

    <div class="user_setting_modals">
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
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.spoiler_link').each(function () {
                $(this).click(function () {
                    $('.spoiler_body_' + $(this).attr('data-schedule')).toggle('normal');
                });
            });

            if ($(window).width() > 576) {
                $('#admin-table').DataTable({
                    'language': {
                        "decimal": "",
                        "emptyTable": "Нет пользователей",
                        "info": "Пользователь с _START_ по _END_ из _TOTAL_",
                        "infoEmpty": "Нет пользователей",
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

                $('#admin-table').show()
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
