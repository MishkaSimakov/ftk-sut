@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center">{{ auth()->user()->name }}</h1>
@endsection
