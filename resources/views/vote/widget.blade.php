@extends('layouts.navless')

@section('content')
    <vote active="{{ auth()->check() }}" data="{{ $vote->toJson() }}"></vote>
@endsection
