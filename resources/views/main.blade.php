@extends('layouts.page')

@section('content')
    @component('components.sections.section', ['header' => 'Новости'])
        @component('components.card-lists.news', ['news' => $news])@endcomponent
    @endcomponent

    @component('components.sections.section', ['header' => 'Наши преподаватели'])
        @component('components.card-lists.teachers', ['teachers' => $teachers])@endcomponent
    @endcomponent

    @component('components.sections.section', ['header' => 'Наши преимущества'])
        @include('partials.advantages.advantage-list', ['advantages' => $advantages])
    @endcomponent
@endsection

@push('script')
    <script>
        const teachersToggle = document.getElementById('teachersToggle');
        const teachers = document.getElementById('teachers');
        const toggled = document.querySelector('.toggled--teachers');
        const noneToggled = document.querySelector('.none-toggled--teachers');

        teachersToggle.addEventListener('click', function () {
            teachers.classList.toggle('full-size');
            noneToggled.classList.toggle('full-size');
            toggled.classList.toggle('full-size');
        });
    </script>
@endpush
