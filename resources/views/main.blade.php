@extends('layouts.page')

@section('content')
    @if($news->count())
        @component('components.sections.section', ['header' => 'Новости'])
            @component('components.card-lists.news', ['news' => $news])@endcomponent
        @endcomponent
    @endif

    @component('components.sections.section', ['header' => 'Наши преподаватели'])
        @component('components.card-lists.teachers', ['teachers' => $teachers])@endcomponent
    @endcomponent

    @component('components.sections.section', ['header' => 'Наши преимущества'])
        @include('partials.advantages.advantage-list', ['advantages' => $advantages])
    @endcomponent
@endsection
