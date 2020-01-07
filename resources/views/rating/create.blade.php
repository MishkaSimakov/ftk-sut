@extends('layouts.page')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header">Загрузить рейтинг</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rating.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Рейтинг</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control-file" accept=".xls" name="file" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Тип</label>

                            <div class="col-md-6">
                                <select class="form-control" name="type" id="type" required>
                                  <option value="1" selected>Рейтинг за месяц</option>
                                  <option value="0">Рейтинг за год</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="type-month">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Дата</label>

                            <div class="col-md-6">
                                <input id="date" type="month" value="{{ Carbon\Carbon::now()->format('Y-m') }}" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" required>

                                @if (session('date'))
                                    <div class="invalid-feedback d-block">
                                        {{ session('date') }}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Загрузить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('script')
    <script>
        $(document).on('input', '#type', function () {
            var val = $(this).val();

            if (val == 1) {
                $('#date').attr('type', 'month');
                $('#date').val("{{ Carbon\Carbon::now()->format('Y-m') }}");
            } else {
                $('#date').attr('type', 'number');
                $('#date').val("{{ Carbon\Carbon::now()->format('Y') }}");
            }
        });
    </script>
@endpush
