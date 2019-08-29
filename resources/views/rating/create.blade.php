@include('partials.header')

<h1 class="text-center m-2">Загрузить рейтинг</h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rating.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Рейтинг</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class=".form-control-file" accept=".xls" name="file" required>
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


                        <div class="form-group row" style="display: none;" id="type-year">
                            <label for="year" class="col-md-4 col-form-label text-md-right">Дата</label>

                            <div class="col-md-6">
                                <input id="year" type="number" value="{{ Carbon\Carbon::now()->format('Y') }}" class="form-control" name="year" required>
                            </div>
                        </div>

                        <div class="form-group row" id="type-month">
                            <label for="month" class="col-md-4 col-form-label text-md-right">Дата</label>

                            <div class="col-md-6">
                                <input id="month" type="month" value="{{ Carbon\Carbon::now()->format('Y-m') }}" class="form-control" name="month" required>
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

<script>
    $(document).on('input', '#type', function () {
        var val = $(this).val();

        $('#type-year').toggle('');
        $('#type-month').toggle('');
    });
</script>

@include('partials.footer')