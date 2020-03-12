@extends('layouts.page')

@section('content')

<h1 class="text-center m-2">Требуют проверки</h1>

<div class="m-3">
    @component('components.card-lists.articles', ['articles' => $articles])@endcomponent
</div>

@endsection
