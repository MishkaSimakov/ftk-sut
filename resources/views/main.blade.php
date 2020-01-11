@extends('layouts.page')

@section('content')
    @component('components.sections.section', ['header' => 'Наши преподаватели'])
        @component('components.card-lists.teachers', ['teachers' => $teachers])@endcomponent
    @endcomponent

    @component('components.sections.section', ['header' => 'Наши преимущества'])
        @include('partials.advantages.advantage-list', ['advantages' => $advantages])
    @endcomponent

    @component('components.sections.section', ['header' => 'Лучшие статьи'])
        @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
    @endcomponent
@endsection
