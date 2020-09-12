@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Панель администратора</h1>

    <div class="container mt-2">
        <div class="card shadow mb-2">
            <div class="card-header">
                <h6>
                    Ученики
                    <a class="ml-2" title="Добавить пользователя" href="{{ route('admin.user.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                </h6>
            </div>

            <div class="card-body">
                <div class="d-block d-lg-none">
                    <div class="form-group row">
                        <label for="user" class="col-md-4 col-form-label text-md-right">Имя пользователя</label>

                        <div class="col-md-7">
                            <input oninput="get_code(this)" list="users" id="user" type="text" class="form-control" name="user" required>
                        </div>

                        <datalist id="users">
                            @foreach($students as $student)
                                <option>{{ $student->name}}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="form-group row">
                        <label for="user" class="col-md-4 col-form-label text-md-right">Регистрационный код</label>

                        <div class="col-md-7 py-2">
                            <span id="register_code">...</span>
                        </div>
                    </div>
                </div>

                <table id="students-table" class="table table-striped table-bordered" style="display: none; width:100%">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Регистрационный код</th>
                            <th>Зарегистрирован</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td><a href="{{ $student->url }}" title="Страница пользователя">{{ $student->name }}</a></td>
                                <td>{{ $student->register_code }}</td>
                                <td>{{ $student->email ? 'Да' : 'Нет' }}</td>
                                <td class="text-center"><a href="{{ route('settings.show.admin', ['user' => $student]) }}"><i class="fas fa-user-cog"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow mb-2">
            <div class="card-header">
                <h6>Преподаватели</h6>
            </div>

            <div class="card-body">
                <table id="teachers-table" style="display: none" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Регистрационный код</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->full_name }}</td>
                                <td>{{ $teacher->user->register_code }}</td>

                                <td class="text-center"><a href="{{ route('settings.show.admin', ['user' => $teacher->user]) }}"><i class="fas fa-user-cog"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow mb-2">
            <div class="card-header">
                <h6>Импорт походов</h6>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('travels.import') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">Походы</label>

                        <div class="col-md-6">
                            <input id="file" type="file" class="form-control-file{{ $errors->has('file') ? ' is-invalid' : '' }}" accept=".xls" name="file" required>

                            <small class="text-muted">Пример файла для импорта можно скачать по <a href="{{ asset('excel/travels.xls') }}">ссылке</a></small>

                            @if ($errors->has('file'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Импортировать
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            if ($(window).width() > 992) {
                $('#teachers-table').show();

                $('#students-table').show().DataTable({
                    'columnDefs': [{
                        "targets": [-1],
                        "orderable": false
                    }],
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
