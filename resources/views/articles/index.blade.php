@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center">Статьи</h1>

    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center">
                <i class="fas fa-star"></i>
                Выбор редакции
            </h2>

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Привет мир!</h5>
                    <div class="card-text">Это очень интересная статья</div>

                    <div class="row no-gutters">
                        <p class="card-text mb-0 mt-1"><small class="text-muted">12.03.2005</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
