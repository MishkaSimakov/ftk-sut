@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center">{{ auth()->user()->name }}</h1>

    <h2>
        Достижения
    </h2>

    <div class="card">
        <div class="card-img col-2 p-0">
            <img
                src="https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png"
                class="img-fluid mw-100 rounded-left"
            >
        </div>
    </div>
@endsection
