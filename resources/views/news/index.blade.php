@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">Новости</h1>

    <div class="container">
        @admin
            <div class="mb-2 card shadow w-100">
                <div class="card-body py-2 row">
                    <a href="{{ route('news.create') }}" class="ml-2 font-weight-bolder">
                        <i class="fas fa-plus my-auto mr-1"></i>
                        Добавить новость
                    </a>
                </div>
            </div>
        @endadmin

        @component('components.card-lists.news', ['news' => $news])@endcomponent
    </div>
@endsection
