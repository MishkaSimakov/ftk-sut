@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Новости</h1>

    @admin
        <h2 class="ml-2"><a href="{{ route('news.create') }}"><i class="fas fa-plus mr-1"></i>Добавить новость</a></h2>
    @endadmin

    <div class="m-3">
        @component('components.card-lists.news', ['news' => $news])@endcomponent
    </div>
@endsection
