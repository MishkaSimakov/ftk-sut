@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Черновики</h1>

    <div class="container">
        <div class="alert alert-info alert-dismissible fade show" role="contentinfo">
            Здесь отображаются ваши черновики. Вы можете отредактировать их в любое время и опубликовать, когда они будут готовы. Можно хранить до 10 черновиков.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @if ($articles->count() >= 10)
            <div class="alert alert-danger alert-dismissible fade show" role="contentinfo">
                <b>Внимание!</b> Вы достигли лимита черновиков. Чтобы добавить ещё один, удалите старые.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="mt-3">
            @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
        </div>
    </div>

@endsection

@push('side')
    @component('components.navs.article')@endcomponent
@endpush
