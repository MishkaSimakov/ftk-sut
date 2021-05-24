@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Карта сайта')

@section('content')
    <h1 class="text-center mb-4">Карта сайта</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Новости</h2>

            <a href="{{ route('news.index') }}">Список новостей</a>
        </div>
    </div>
@endsection
