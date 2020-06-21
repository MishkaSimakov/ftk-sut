@extends('layouts.page')

@section('content')

<div class="container">
    <div class="card shadow mt-2">
        <div class="card-header">
            <h4 class="font-weight-bold text-primary">Статья</h4>
        </div>

        <div class="card-body container">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('article.update', compact('article')) }}">
                @csrf
                @method("PUT")

                <div class="form-group">
                    <label for="title">Название статьи</label>
                    <input max="100" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') ?? $article->title }}" required>

                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="editor">Статья</label>

                    <textarea name="body" id="editor">
                        {!! old('body') ?? $article->body !!}
                    </textarea>
                </div>

                @admin
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input list="users" id="user" type="text" class="form-control" name="author" value="{{ optional($article->user)->name ?? Auth::user()->name }}">

                        <datalist id="users">
                            @foreach($names as $name)
                                <option>{{ $name }}</option>
                            @endforeach
                        </datalist>
                    </div>
                @endadmin

                <tags-add-form value="{{ $article->tags->pluck('name') }}"></tags-add-form>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-outline-primary">
                        Опубликовать
                    </button>

                    <div class="d-inline-block">
                        <button name="is_blank" value="true" type="submit" class="btn btn-outline-secondary {{ !$is_draftable ? 'disabled' : '' }}" {{ !$is_draftable ? 'disabled' : '' }}>
                            Добавить в черновики
                        </button>
                    </div>
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
                selector: '#editor',
                branding: false,
                plugins: [
                    "lists link image fullscreen",
                ],
                toolbar: 'styleselect | fontsizeselect  | bold italic underline | numlist bullist | link image voting | undo redo | fullscreen',
                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                menubar: '',
                language: 'ru',

                /* without images_upload_url set, Upload tab won't show up*/
                images_upload_url: '{{ route('api.article.upload_image', compact('article')) }}',
                // statusbar: false,
                relative_urls: false,
                remove_script_host: false,

                setup: function (editor) {
                    editor.ui.registry.addMenuButton('voting', {
                        text: 'Голосования',
                        fetch: function (callback) {
                            let items = [
                                {
                                    type: 'menuitem',
                                    text: 'Вставить',
                                    onAction: function () {
                                        new Promise((resolve, reject) => {
                                            axios.get('/webapi/vote/all').then(function (response) {
                                                let options = Object.values(response.data);

                                                tinymce.activeEditor.windowManager.open({
                                                    title: 'Вставка опроса',
                                                    body: {
                                                        type: 'panel',
                                                        items: [
                                                            {
                                                                type: 'selectbox',
                                                                name: 'voting',
                                                                label: 'Выберите голосование',
                                                                items: options,
                                                            }
                                                        ]
                                                    },
                                                    buttons: [
                                                        {
                                                            type: 'cancel',
                                                            name: 'closeButton',
                                                            text: 'Отменить'
                                                        },
                                                        {
                                                            type: 'submit',
                                                            name: 'submitButton',
                                                            text: 'Вставить',
                                                            primary: true
                                                        }
                                                    ],
                                                    onSubmit: function (api) {
                                                        let data = api.getData();

                                                        tinymce.activeEditor.execCommand('mceInsertContent', false, '<div class="embed-responsive embed-responsive-16by9 z-depth-2"><iframe class="embed-responsive-item" src="/vote/' + data.voting + '/widget"></iframe></div>');
                                                        api.close();
                                                    }
                                                });
                                            })
                                        })
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'Создать',
                                    onAction: function () {
                                        let win = window.open('{{ route('vote.create') }}', '_blank');
                                        win.focus();
                                    }
                                }
                            ];
                            callback(items);
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('side')
    @component('components.navs.article')@endcomponent
@endpush
