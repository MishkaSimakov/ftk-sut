@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="card shadow mt-2">
            <div class="card-header">Загрузить рейтинг</div>

            <div class="card-body">
                <form method="POST" action="{{ route('travels.import') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">Рейтинг</label>

                        <div class="col-md-6">
                            <input id="file" type="file" class="form-control-file{{ $errors->has('file') ? ' is-invalid' : '' }}" accept=".xls" name="file" required>

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
                                Загрузить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
