@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Статистика</h1>

    <recent-actions url="{{ route('articles.statistics.actions') }}"></recent-actions>

    <articles-top url="{{ route('articles.statistics.articles') }}"></articles-top>

    <writers-top url="{{ route('articles.statistics.writers') }}"></writers-top>
@endsection

@push('side')
    @component('components.navs.article')@endcomponent
@endpush
