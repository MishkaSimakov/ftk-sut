@extends('layouts.page')

@section('content')
    <div class="container">
        <div class="card shadow mt-2">
            <div class="card-header">
                <h4 class="font-weight-bold text-primary">Новость</h4>
            </div>

            <div class="card-body">
                <form id="form" method="POST" action="{{ route('news.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Название новости</label>
                        <input max="100" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>

                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="body">Текст</label>

                        <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body">
                            {!! old('body') !!}
                        </textarea>

                        @if ($errors->has('body'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-outline-primary">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.tiny.cloud/1/hnviucqus9116ko1nycfet8r4rlvw0akh6w27lord3o9nz15/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#body',
                branding: false,
                plugins: [
                    "lists link",
                ],
                toolbar: 'bold italic underline | numlist bullist | link | undo redo | fullscreen',
                menubar: '',
                language: 'ru',
            });
        });
    </script>
@endpush
